<?php

namespace App\Repositories\Eloquent;

use Core\Domain\Exception\NotFoundException;
use App\Models\Example as Model;
use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Entity\Example;
use Core\Domain\Repository\ExampleRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;

class ExampleEloquentRepository implements ExampleRepositoryInterface
{
    protected $model;

    public function __construct(Model $example)
    {
        $this->model = $example;    
    }

    public function insert(Example $example): Example
    {
        $example = $this->model->create([
            'id' => $example->id(),
            'name' => $example->name,
            'description' => $example->description,
            'is_active' => $example->isActive,
            'create_at' => $example->createdAt(),
        ]);

        return $this->toExample($example);
    }

    public function findById(string $exampleId): Example
    {
        if (!$example = $this->model->find($exampleId)) {
            throw new NotFoundException('Example not found');
        }

        return $this->toExample($example);
    }

    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        $examples = $this->model
                            ->where(function ($query) use ($filter) {
                                if ($filter)
                                    $query->where('name', 'ILIKE', "%{$filter}%");
                            })
                            ->orderBy('id', $order)
                            ->get();

        return $examples->toArray();
    }

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface
    {
        $query = $this->model;
        if ($filter) {
            $query->where('name', 'LIKE', "%{$filter}%");
        }
        $query->orderBy('id', $order);
        $paginator = $query->paginate();

        return new PaginationPresenter($paginator);
    }

    public function update(Example $example): Example
    {
        if (!$exampleDb = $this->model->find($example->id)) {
            throw new NotFoundException('Example not found');
        }

        $exampleDb->update([
            'name' => $example->name,
            'description' => $example->description,
            'is_active' => $example->isActive
        ]);

        $exampleDb->refresh();

        return $this->toExample($exampleDb);
    }

    public function delete(string $exampleId): bool
    {
        if (!$exampleDb = $this->model->find($exampleId)) {
            throw new NotFoundException('Example not found');
        }

        return $exampleDb->delete();
    }

    private function toExample(object $object): Example
    {
        $entity = new Example(
            id: $object->id,
            name: $object->name,
            description: $object->description,
        );
        ((bool) $object->is_active) ? $entity->activate() : $entity->disable();

        return $entity;
    }

}