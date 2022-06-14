<?php

namespace Tests\Feature\Core\UseCase\Example;

use App\Models\Example as Model;
use App\Repositories\Eloquent\ExampleEloquentRepository;
use Core\UseCase\Example\DeleteExampleUseCase;
use Core\UseCase\Example\ListExamplesUseCase;
use Core\UseCase\DTO\Example\ExampleInputDto;
use Core\UseCase\DTO\Example\ListExamples\ListExamplesInputDto;
use Tests\TestCase;

class ListExamplesUseCaseTest extends TestCase
{
    public function test_list_empty()
    {
        $responseUseCase = $this->createUseCase();

        $this->assertCount(0, $responseUseCase->items);
    }

    public function test_list_all()
    {
        $examplesDb = Model::factory()->count(20)->create();

        $responseUseCase = $this->createUseCase();

        $this->assertCount(15, $responseUseCase->items);
        $this->assertEquals(count($examplesDb), $responseUseCase->total);
    }

    private function createUseCase()
    {
        $repository = new ExampleEloquentRepository(new Model());
        $useCase = new ListExamplesUseCase($repository);
        return $useCase->execute(new ListExamplesInputDto());
    }
}
