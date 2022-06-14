<?php

namespace Tests\Feature\Core\UseCase\Example;

use App\Models\Example as Model;
use App\Repositories\Eloquent\ExampleEloquentRepository;
use Core\UseCase\Example\UpdateExampleUseCase;
use Core\UseCase\DTO\Example\UpdateExample\ExampleUpdateInputDto;
use Tests\TestCase;

class UpdateExampleUseCaseTest extends TestCase
{
    public function test_update()
    {
        $exampleDb = Model::factory()->create();

        $repository = new ExampleEloquentRepository(new Model());
        $useCase = new UpdateExampleUseCase($repository);
        $responseUseCase = $useCase->execute(
            new ExampleUpdateInputDto(
                id: $exampleDb->id,
                name: 'name updated'
            )
        );

        $this->assertEquals('name updated', $responseUseCase->name);
        $this->assertEquals($exampleDb->description, $responseUseCase->description);

        $this->assertDatabaseHas('examples', [
            'name' => $responseUseCase->name
        ]);
    }
}
