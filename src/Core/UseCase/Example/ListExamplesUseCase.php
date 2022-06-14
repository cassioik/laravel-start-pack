<?php

namespace Core\UseCase\Example;

use Core\Domain\Repository\ExampleRepositoryInterface;
use Core\UseCase\DTO\Example\ListExamples\{
    ListExamplesInputDto,
    ListExamplesOutputDto
};

class ListExamplesUseCase
{
    protected $repository;

    public function __construct(ExampleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ListExamplesInputDto $input): ListExamplesOutputDto
    {
        $examples = $this->repository->paginate(
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            totalPage: $input->totalPage,
        );

        return new ListExamplesOutputDto(
            items: $examples->items(),
            total: $examples->total(),
            current_page: $examples->currentPage(),
            last_page: $examples->lastPage(),
            first_page: $examples->firstPage(),
            per_page: $examples->perPage(),
            to: $examples->to(),
            from: $examples->from(),
        );

        // return new ListExamplesOutputDto(
        //     items: array_map(function ($data) {
        //         return [
        //             'id' => $data->id,
        //             'name' => $data->name,
        //             'description' => $data->description,
        //             'is_active' => (bool) $data->is_active,
        //             'created_at' => (string) $data->created_at,
        //         ];
        //     }, $examples->items()),
        //     total: $examples->total(),
        //     last_page: $examples->lastPage(),
        //     first_page: $examples->firstPage(),
        //     per_page: $examples->perPage(),
        //     to: $examples->to(),
        //     from: $examples->to(),
        // );
    }
}
