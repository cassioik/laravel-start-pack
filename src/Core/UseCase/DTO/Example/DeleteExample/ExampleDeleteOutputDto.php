<?php

namespace Core\UseCase\DTO\Example\DeleteExample;

class ExampleDeleteOutputDto
{
    public function __construct(
        public bool $success
    ) {}
}
