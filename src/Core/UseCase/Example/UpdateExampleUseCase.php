<?php

namespace Core\UseCase\Example;

use Core\Domain\Repository\ExampleRepositoryInterface;
use Core\UseCase\DTO\Example\UpdateExample\ExampleUpdateInputDto;
use Core\UseCase\DTO\Example\UpdateExample\ExampleUpdateOutputDto;

class UpdateExampleUseCase
{
    protected $repository;

    public function __construct(ExampleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ExampleUpdateInputDto $input): ExampleUpdateOutputDto
    {
        $example = $this->repository->findById($input->id);

        $example->update(
            name: $input->name,
            description: $input->description ?? $example->description,
        );

        $exampleUpdated = $this->repository->update($example);

        return new ExampleUpdateOutputDto(
            id: $exampleUpdated->id,
            name: $exampleUpdated->name,
            description: $exampleUpdated->description,
            is_active: $exampleUpdated->isActive,
            created_at: $exampleUpdated->createdAt(),
        );
    }
}
