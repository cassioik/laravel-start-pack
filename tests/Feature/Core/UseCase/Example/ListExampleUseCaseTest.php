<?php

namespace Tests\Feature\Core\UseCase\Example;

use App\Models\Example as Model;
use App\Repositories\Eloquent\ExampleEloquentRepository;
use Core\UseCase\Example\DeleteExampleUseCase;
use Core\UseCase\Example\ListExampleUseCase;
use Core\UseCase\DTO\Example\ExampleInputDto;
use Tests\TestCase;

class ListExampleUseCaseTest extends TestCase
{
    public function test_list()
    {
        $exampleDb = Model::factory()->create();

        $repository = new ExampleEloquentRepository(new Model());
        $useCase = new ListExampleUseCase($repository);
        $responseUseCase = $useCase->execute(
            new ExampleInputDto(
                id: $exampleDb->id
            )
        );

        $this->assertEquals($exampleDb->id, $responseUseCase->id);
        $this->assertEquals($exampleDb->name, $responseUseCase->name);
        $this->assertEquals($exampleDb->description, $responseUseCase->description);
    }
}
