# anasa-response-strategy
Package to isolate the logic that determines the return type of the controller based on the source (API/Web).

This is an optional solution in Laravel to handle the type of output that will be implemented for a crud. Make sure to respect the naming standards or you will need to modify the AdditionalDataRequest inputs for (setMethod, setView, setRoute).

## How it works:
1- From a middleware or similar logic set the Additional Data Request and identify the required Response Strategy

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SebastianBergmann\Type\Exception;
use Symfony\Component\HttpFoundation\Response;
use Anasa\ResponseStrategy\{AdditionalDataRequest,ResponseStrategyFactory,ResponseContextInterface};

class ApiOrWebMiddleware
{
    public function __construct(protected ResponseContextInterface $responseContext)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * Set additional data request:
         * this will add the controller, method, view and resource. It's
         * some dinamic data to be used in the strategy to identify and build
         * the response. A facade will be used.
         */
        $service = AdditionalDataRequest::getInstance();
        $this->setAdditionalDataRequest($request, $service);

        $this->defineResponseStrategy($service);

        return $next($request);
    }

    private function setAdditionalDataRequest(Request $request, $service): void
    {
        $action = $request->route()->getAction();
        $controller = class_basename($action['controller']);
        [, $methodName] = explode('@', $controller);
        
        $service->setMethod($request->expectsJson() || $request->is('api/*') ? 'API' : $methodName);
        $service->setView($request->route()->getName());
        $service->setRoute($request->route()->getName());
    }
    
    public function defineResponseStrategy()
    {
        try {
            $strategy = ResponseStrategyFactory::createStrategy($service->getMethod());
        } catch (Exception $e) {
            throw new Exception('Unknown method');
        }

        $this->responseContext->setStrategy($strategy);
    }
}

```
**Notes:**
- setMethod will set as API for all input json output.
- If your project uses a custom prefix for API inputs, make sure to add the Accept: application/json Header to identify if a json output.
```php
$service->setMethod($request->expectsJson() || $request->is('api/*') ? 'API' : $methodName);
```

2- Set Service Provider and Response Service provider,

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Anasa\ResponseStrategy\AdditionalDataRequest;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //...
        $this->app->singleton('additionalDataRequest', function ($app) {
            return new AdditionalDataRequest;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       //
    }
}

```

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Anasa\ResponseStrategy\{ResponseContext,ResponseContextInterface};
use Anasa\ResponseStrategy\Output\{ApiResponseStrategy, ViewResponseStrategy, RedirectResponseStrategy};
use Anasa\ResponseStrategy\OutputDataFormat\{StrategyData,StrategyDataInterface};

class ResponseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ApiResponseStrategy::class, function ($app) {
            return new ApiResponseStrategy();
        });

        $this->app->bind(ViewResponseStrategy::class, function ($app) {
            return new ViewResponseStrategy();
        });

        $this->app->bind(RedirectResponseStrategy::class, function ($app) {
            return new RedirectResponseStrategy();
        });
        $this->app->bind(StrategyDataInterface::class, function ($app) {
            return new StrategyData();
        });

        $this->app->singleton(ResponseContextInterface::class, function ($app) {
            return new ResponseContext();
        });
    }
}

```

3- Using it in your controller. ***No checks nor conditionalities, just input and output of requests with a single way.*** 

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Repositories\YourRepository;
use Anasa\ResponseStrategy\ResponseContextInterface;
use Anasa\ResponseStrategy\OutputDataFormat\StrategyDataInterface;

class YourController extends Controller
{
    public function __construct(protected YourRepository $repository, protected ResponseContextInterface $responseContext, protected StrategyDataInterface $strategyData)
    {
    }
    
    public function index(): View|JsonResponse
    {
        $data = $this->repository->all();
        $strategy = $this->strategyData->setStrategyData(YourResource::collection($data));

        return $this->responseContext->executeStrategy($strategy);
    }

    /**
     * No strategy needed
    */
    public function create(): View
    {
        return View('yourResource.create');
    }

    public function store(YourRequest $request): JsonResponse|RedirectResponse
    {
        
        $data = $this->repository->create($request->validated());
        $strategy = $this->strategyData->setStrategyData(new YourResource($data), 'YourResource created successfully', Response::HTTP_CREATED);

        return $this->responseContext->executeStrategy($strategy);
    }

    public function show($id): JsonResponse|View
    {
        $data = $this->repository->find($id); //it uses findOrFail from the repository
        $strategy = $this->strategyData->setStrategyData(new YourResource($data));

        return $this->responseContext->executeStrategy($strategy);
    }

    public function edit(string $id): View
    {
        $data = $this->repository->find($id); //it uses findOrFail from the repository
        return View('gateway.edit', ['YourData' => $data]);
    }

    public function update(YourRequest $request, string $id): JsonResponse|RedirectResponse
    {
        $updated_data = $this->repository->update($id, $request->validated()); //it uses findOrFail
        $strategy = $this->strategyData->setStrategyData(new YourResource($updated_data), 'YourResource updated successfully', Response::HTTP_OK);

        return $this->responseContext->executeStrategy($strategy);
    }

    public function destroy($id): JsonResponse|RedirectResponse
    {
        $this->repository->delete($id); //it uses findOrFail from the repository

        return $this->responseContext->executeStrategy($this->strategyData->setStrategyData([], 'YourResource deleted successfully', Response::HTTP_OK));
    }
```
4- For testing, you can add: *$service->setMethod('API');*
```php
namespace Tests\Feature;

use Tests\TestCase;
use Anasa\ResponseStrategy\Facades\AdditionalDataRequest;

class GatewayTest extends TestCase
{
  

    protected function setUp(): void
    {
        parent::setUp();

        $service->setMethod('API');
    }
```