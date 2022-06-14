<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Example;

interface ExampleRepositoryInterface
{
    public function insert(Example $example): Example;
    public function findById(string $exampleId): Example;
    public function findAll(string $filter = '', $order = 'DESC'): array;
    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface;
    public function update(Example $example): Example;
    public function delete(string $exampleId): bool;
}
