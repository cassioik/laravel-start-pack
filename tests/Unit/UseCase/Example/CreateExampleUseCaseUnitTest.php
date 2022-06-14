<?php

namespace Tests\Unit\UseCase\Example;

use Core\Domain\Entity\Example;
use Core\Domain\Repository\ExampleRepositoryInterface;
use Core\UseCase\Example\CreateExampleUseCase;
use Core\UseCase\DTO\Example\CreateExample\{
    ExampleCreateInputDto,
    ExampleCreateOutputDto
};
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateExampleUseCaseUnitTest extends TestCase
{
    public function testCreateNewExample()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $exampleName = 'name cat';

        $this->mockEntity = Mockery::mock(Example::class, [
            $uuid,
            $exampleName
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);

        $this->mockRepo = Mockery::mock(stdClass::class, ExampleRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(ExampleCreateInputDto::class, [
            $exampleName,
        ]);

        $useCase = new CreateExampleUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(ExampleCreateOutputDto::class, $responseUseCase);
        $this->assertEquals($exampleName, $responseUseCase->name);
        $this->assertEquals('', $responseUseCase->description);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, ExampleRepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($this->mockEntity);
        $useCase = new CreateExampleUseCase($this->spy);
        $responseUseCase = $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('insert');

        Mockery::close();
    }
}
