<?php

namespace Tests\Unit\UseCase\Example;

use Core\Domain\Entity\Example as ExampleEntity;
use Core\Domain\Repository\ExampleRepositoryInterface;
use Core\UseCase\Example\ListExampleUseCase;
use Core\UseCase\DTO\Example\ExampleInputDto;
use Core\UseCase\DTO\Example\ExampleOutupDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListExampleUseCaseUnitTest extends TestCase
{
    public function testGetById()
    {
        $id = (string) Uuid::uuid4()->toString();

        $this->mockEntity = Mockery::mock(ExampleEntity::class, [
            $id,
            'teste example'
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($id);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class, ExampleRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')
                        ->with($id)
                        ->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(ExampleInputDto::class, [
            $id,
        ]);

        $useCase = new ListExampleUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(ExampleOutupDto::class, $response);
        $this->assertEquals('teste example', $response->name);
        $this->assertEquals($id, $response->id);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, ExampleRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->with($id)->andReturn($this->mockEntity);
        $useCase = new ListExampleUseCase($this->spy);
        $response = $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('findById');
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
