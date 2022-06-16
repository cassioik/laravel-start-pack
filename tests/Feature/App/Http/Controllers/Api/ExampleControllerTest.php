<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Http\Requests\{
    StoreExampleRequest,
    UpdateExampleRequest
};
use App\Http\Controllers\Api\ExampleController;
use App\Models\Example;
use App\Repositories\Eloquent\ExampleEloquentRepository;
use Core\UseCase\Example\{
    CreateExampleUseCase,
    DeleteExampleUseCase,
    ListExamplesUseCase,
    ListExampleUseCase,
    UpdateExampleUseCase
};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\TestCase;

class ExampleControllerTest extends TestCase
{
    protected $repository;

    protected $controller;

    protected function setUp(): void
    {
        $this->repository = new ExampleEloquentRepository(
            new Example()
        );

        $this->controller = new ExampleController();

        parent::setUp();
    }

    public function test_index()
    {
        $useCase = new ListExamplesUseCase($this->repository);

        $response = $this->controller->index(new Request(), $useCase);

        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
        $this->assertArrayHasKey('meta', $response->additional);
    }

    public function test_store()
    {
        $useCase = new CreateExampleUseCase($this->repository);

        $request = new StoreExampleRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'name' => 'Teste'
        ]));

        $response = $this->controller->store($request, $useCase);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
    }

    public function test_show()
    {
        $example = Example::factory()->create();

        $response = $this->controller->show(
            useCase: new ListExampleUseCase($this->repository),
            id: $example->id
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
    }

    public function test_update()
    {
        $example = Example::factory()->create();

        $request = new UpdateExampleRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'name' => 'Updated'
        ]));

        $response = $this->controller->update(
            request: $request,
            useCase: new UpdateExampleUseCase($this->repository),
            id: $example->id
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
    }

    public function test_delete()
    {
        $example = Example::factory()->create();

        $response = $this->controller->destroy(
            useCase: new DeleteExampleUseCase($this->repository),
            id: $example->id
        );

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->status());
    }
}
