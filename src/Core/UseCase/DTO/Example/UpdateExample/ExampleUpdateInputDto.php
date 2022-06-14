<?php

namespace Core\UseCase\DTO\Example\UpdateExample;

class ExampleUpdateInputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string|null $description = null,
        public bool $isActive = true,
    ) {}
}
