<?php

namespace Tests\Unit\UseCase\Example;

use Core\Domain\Entity\Example as EntityExample;
use Core\Domain\Repository\ExampleRepositoryInterface;
use Core\UseCase\Example\UpdateExampleUseCase;
use Core\UseCase\DTO\Example\UpdateExample\{
    ExampleUpdateInputDto,
    ExampleUpdateOutputDto
};
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class UpdateExampleUseCaseUnitTest extends TestCase
{
    public function testRenameExample()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $exampleName = 'Name';
        $exampleDesc = 'Desc';

        $this->mockEntity = Mockery::mock(EntityExample::class, [
            $uuid, $exampleName, $exampleDesc
        ]);
        $this->mockEntity->shouldReceive('update');
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class, ExampleRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->mockRepo->shouldReceive('update')->andReturn($this->mockEntity);


        $this->mockInputDto = Mockery::mock(ExampleUpdateInputDto::class, [
            $uuid,
            'new name',
        ]);

        $useCase = new UpdateExampleUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(ExampleUpdateOutputDto::class, $responseUseCase);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, ExampleRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->spy->shouldReceive('update')->andReturn($this->mockEntity);
        $useCase = new UpdateExampleUseCase($this->spy);
        $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('findById');
        $this->spy->shouldHaveReceived('update');

        Mockery::close();
    }
}
