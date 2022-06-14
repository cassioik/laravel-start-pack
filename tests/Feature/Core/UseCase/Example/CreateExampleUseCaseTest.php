<?php

namespace Tests\Feature\Core\UseCase\Example;

use App\Models\Example as Model;
use App\Repositories\Eloquent\ExampleEloquentRepository;
use Core\Domain\Entity\Example;
use Core\UseCase\Example\CreateExampleUseCase;
use Core\UseCase\DTO\Example\CreateExample\ExampleCreateInputDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateExampleUseCaseTest extends TestCase
{
    public function test_create()
    {
        $repository = new ExampleEloquentRepository(new Model());
        $useCase = new CreateExampleUseCase($repository);
        $responseUseCase = $useCase->execute(
            new ExampleCreateInputDto(
                name: 'Teste'
            )
        );

        $this->assertEquals('Teste', $responseUseCase->name);
        $this->assertNotEmpty($responseUseCase->id);

        $this->assertDatabaseHas('examples', [
            'id' => $responseUseCase->id
        ]);
    }
}
