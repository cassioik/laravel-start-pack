<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\{
    StoreExampleRequest,
    UpdateExampleRequest
};
use App\Http\Resources\ExampleResource;
use Core\UseCase\Example\{
    CreateExampleUseCase,
    DeleteExampleUseCase,
    ListExamplesUseCase,
    ListExampleUseCase,
    UpdateExampleUseCase
};
use Core\UseCase\DTO\Example\ExampleInputDto;
use Core\UseCase\DTO\Example\CreateExample\ExampleCreateInputDto;
use Core\UseCase\DTO\Example\ListExamples\ListExamplesInputDto;
use Core\UseCase\DTO\Example\UpdateExample\ExampleUpdateInputDto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExampleController extends Controller
{
    public function index(Request $request, ListExamplesUseCase $useCase)
    {
        $response = $useCase->execute(
            input: new ListExamplesInputDto(
                filter: $request->get('filter', ''),
                order: $request->get('order', 'DESC'),
                page: (int) $request->get('page', 1),
                totalPage: (int) $request->get('total_page', 15)
            )
        );

        return ExampleResource::collection(collect($response->items))
                                    ->additional([
                                        'meta' => [
                                            'total' => $response->total,
                                            'current_page' => $response->current_page,
                                            'last_page' => $response->last_page,
                                            'first_page' => $response->first_page,
                                            'per_page' => $response->per_page,
                                            'to' => $response->to,
                                            'from' => $response->from,
                                        ]
                                    ]);
    }

    public function store(StoreExampleRequest $request, CreateExampleUseCase $useCase)
    {
        $response = $useCase->execute(
            input: new ExampleCreateInputDto(
                name: $request->name,
                description: $request->description ?? '',
                isActive: (bool) $request->is_active ?? true
            )
        );

        return (new ExampleResource($response))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ListExampleUseCase $useCase, $id)
    {
        $example = $useCase->execute(new ExampleInputDto($id));

        return (new ExampleResource($example))->response();
    }

    public function update(UpdateExampleRequest $request, UpdateExampleUseCase $useCase, $id)
    {
        $response = $useCase->execute(
            input: new ExampleUpdateInputDto(
                id: $id,
                name: $request->name
            )
        );

        return (new ExampleResource($response))->response();
    }

    public function destroy(DeleteExampleUseCase $useCase, $id)
    {
        $useCase->execute(new ExampleInputDto($id));

        return response()->noContent();
    }
}
