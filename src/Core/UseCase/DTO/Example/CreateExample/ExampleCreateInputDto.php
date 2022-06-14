<?php

namespace Core\UseCase\DTO\Example\CreateExample;

class ExampleCreateInputDto
{
    public function __construct(
        public string $name,
        public string $description = '',
        public bool $isActive = true,
    ) {}
}
