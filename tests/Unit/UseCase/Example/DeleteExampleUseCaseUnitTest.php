<?php

namespace Tests\Unit\UseCase\Example;

use Core\Domain\Repository\ExampleRepositoryInterface;
use Core\UseCase\Example\DeleteExampleUseCase;
use Core\UseCase\DTO\Example\ExampleInputDto;
use Core\UseCase\DTO\Example\DeleteExample\ExampleDeleteOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class DeleteExampleUseCaseUnitTest extends TestCase
{
    public function testDelete()
    {
        $uuid = (string) Uuid::uuid4()->toString();

        $this->mockRepo = Mockery::mock(stdClass::class, ExampleRepositoryInterface::class);
        $this->mockRepo->shouldReceive('delete')->andReturn(true);

        $this->mockInputDto = Mockery::mock(ExampleInputDto::class, [$uuid]);

        $useCase = new DeleteExampleUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(ExampleDeleteOutputDto::class, $responseUseCase);
        $this->assertTrue($responseUseCase->success);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, ExampleRepositoryInterface::class);
        $this->spy->shouldReceive('delete')->andReturn(true);
        $useCase = new DeleteExampleUseCase($this->spy);
        $responseUseCase = $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('delete');
    }

    public function testDeleteFalse()
    {
        $uuid = (string) Uuid::uuid4()->toString();

        $this->mockRepo = Mockery::mock(stdClass::class, ExampleRepositoryInterface::class);
        $this->mockRepo->shouldReceive('delete')->andReturn(false);

        $this->mockInputDto = Mockery::mock(ExampleInputDto::class, [$uuid]);

        $useCase = new DeleteExampleUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(ExampleDeleteOutputDto::class, $responseUseCase);
        $this->assertFalse($responseUseCase->success);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
