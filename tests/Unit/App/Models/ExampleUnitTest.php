<?php

namespace Tests\Unit\App\Models;

use App\Models\Example;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExampleUnitTest extends ModelTestCase
{

    protected function model(): Model
    {
        return new Example();
    }

    protected function traits(): array
    {
        return [
            HasFactory::class,
            SoftDeletes::class
        ];
    }

    protected function fillables(): array
    {
        return [
            'id',
            'name',
            'description',
            'is_active'
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'is_active' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }
}
