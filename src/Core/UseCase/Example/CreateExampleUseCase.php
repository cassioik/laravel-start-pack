<?php

namespace Core\UseCase\Example;

use Core\Domain\Entity\Example;
use Core\Domain\Repository\ExampleRepositoryInterface;
use Core\UseCase\DTO\Example\CreateExample\{
    ExampleCreateInputDto,
    ExampleCreateOutputDto
};

class CreateExampleUseCase
{
    protected $repository;

    public function __construct(ExampleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ExampleCreateInputDto $input): ExampleCreateOutputDto 
    {
        $example = new Example(
            name: $input->name,
            description: $input->description,
            isActive: $input->isActive,
        );

        $newExample = $this->repository->insert($example);

        return new ExampleCreateOutputDto(
            id: $newExample->id(),
            name: $newExample->name,
            description: $example->description,
            is_active: $example->isActive,
            created_at: $example->createdAt(),
        );
    }
}
