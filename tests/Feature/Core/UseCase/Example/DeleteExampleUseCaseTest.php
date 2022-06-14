<?php

namespace Tests\Feature\Core\UseCase\Example;

use App\Models\Example as Model;
use App\Repositories\Eloquent\ExampleEloquentRepository;
use Core\UseCase\Example\DeleteExampleUseCase;
use Core\UseCase\DTO\Example\ExampleInputDto;
use Tests\TestCase;

class DeleteExampleUseCaseTest extends TestCase
{
    public function test_delete()
    {
        $exampleDb = Model::factory()->create();

        $repository = new ExampleEloquentRepository(new Model());
        $useCase = new DeleteExampleUseCase($repository);
        $useCase->execute(
            new ExampleInputDto(
                id: $exampleDb->id
            )
        );

        $this->assertSoftDeleted($exampleDb);
    }
}
