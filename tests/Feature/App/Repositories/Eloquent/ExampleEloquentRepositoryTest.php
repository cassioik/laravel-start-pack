<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use Core\Domain\Exception\NotFoundException;
use App\Models\Example as Model;
use App\Models\Example;
use App\Repositories\Eloquent\ExampleEloquentRepository;
use Core\Domain\Entity\Example as EntityExample;
use Core\Domain\Repository\ExampleRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExampleEloquentRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new ExampleEloquentRepository(new Model());
    }

    public function testInsert()
    {
        $entity = new EntityExample(
            name: 'Teste'
        );

        $response = $this->repository->insert($entity);

        $this->assertInstanceOf(ExampleRepositoryInterface::class, $this->repository);
        $this->assertInstanceOf(EntityExample::class, $response);
        $this->assertDatabaseHas('examples', [
            'name' => $entity->name
        ]);
    }

    public function testFindById()
    {
        $example = Model::factory()->create();

        $response = $this->repository->findById($example->id);

        $this->assertInstanceOf(EntityExample::class, $response);
        $this->assertEquals($example->id, $response->id());
    }

    public function testFindByIdNotFound()
    {
        try {
            $this->repository->findById('fakeValue');

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testFindAll()
    {
        $examples = Model::factory()->count(10)->create();

        $response = $this->repository->findAll();

        $this->assertEquals(count($examples), count($response));
    }

    public function testPaginate()
    {
        Model::factory()->count(20)->create();

        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(15, $response->items());
    }

    public function testPaginateWithout()
    {
        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(0, $response->items());
    }

    public function testUpdateNotFound()
    {
        try {
            $example = new EntityExample(name: 'test');

            $this->repository->update($example);

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testUpdate()
    {
        $exampleDb = Example::factory()->create();

        $example = new EntityExample(
            id: $exampleDb->id,
            name: 'updated name'
        );

        $response = $this->repository->update($example);

        $this->assertInstanceOf(EntityExample::class, $response);
        $this->assertNotEquals($response->name, $exampleDb->name);
        $this->assertEquals('updated name', $response->name);
    }

    public function testDeleteNotFound()
    {
        try {
            $this->repository->delete('fake_id');

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testDelete()
    {
        $exampleDb = Example::factory()->create();

        $response = $this->repository->delete($exampleDb->id);

        $this->assertTrue($response);
    }
}
