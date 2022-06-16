<?php

namespace Tests\Unit\App\Http\Controllers\Api;

use App\Http\Controllers\Api\ExampleController;
use Core\UseCase\Example\{
    ListExamplesUseCase
};
use Core\UseCase\DTO\Example\ListExamples\ListExamplesOutputDto;
use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;

class ExampleControllerUnitTest extends TestCase
{
    public function testIndex()
    {
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('get')->andReturn('teste');

        $mockDtoOutput = Mockery::mock(ListExamplesOutputDto::class, [
            [], 1, 1, 1, 1, 1, 1, 1
        ]);

        $mockUseCase = Mockery::mock(ListExamplesUseCase::class);
        $mockUseCase->shouldReceive('execute')->andReturn($mockDtoOutput);

        $controller = new ExampleController();
        $response = $controller->index($mockRequest, $mockUseCase);

        $this->assertIsObject($response->resource);
        $this->assertArrayHasKey('meta', $response->additional);

        /**
         * Spies
         */
        $mockUseCaseSpy = Mockery::spy(ListExamplesUseCase::class);
        $mockUseCaseSpy->shouldReceive('execute')->andReturn($mockDtoOutput);
        $controller->index($mockRequest, $mockUseCaseSpy);
        $mockUseCaseSpy->shouldHaveReceived('execute');

        Mockery::close();
    }
}
