<?php

namespace Core\UseCase\Example;

use Core\Domain\Entity\Example;
use Core\Domain\Repository\ExampleRepositoryInterface;
use Core\UseCase\DTO\Example\{
    ExampleInputDto,
    ExampleOutupDto
};

class ListExampleUseCase
{
    protected $repository;

    public function __construct(ExampleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ExampleInputDto $input): ExampleOutupDto
    {
        $example = $this->repository->findById($input->id);

        return new ExampleOutupDto(
            id: $example->id(),
            name: $example->name,
            description: $example->description,
            is_active: $example->isActive,
            created_at: $example->createdAt(),
        );
    }
}