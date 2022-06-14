<?php

namespace Core\UseCase\Example;

use Core\Domain\Repository\ExampleRepositoryInterface;
use Core\UseCase\DTO\Example\ExampleInputDto;
use Core\UseCase\DTO\Example\DeleteExample\ExampleDeleteOutputDto;

class DeleteExampleUseCase
{
    protected $repository;

    public function __construct(ExampleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ExampleInputDto $input): ExampleDeleteOutputDto
    {
        $responseDelete = $this->repository->delete($input->id);

        return new ExampleDeleteOutputDto(
            success: $responseDelete
        );
    }
}
