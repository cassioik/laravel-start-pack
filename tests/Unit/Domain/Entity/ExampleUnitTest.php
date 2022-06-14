<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Example;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Throwable;

class ExampleUnitTest extends TestCase
{
    public function testAttributes()
    {
        $example = new Example(
            name: 'New Cat',
            description: 'New desc',
            isActive: true
        );

        $this->assertNotEmpty($example->createdAt());
        $this->assertNotEmpty($example->id());
        $this->assertEquals('New Cat', $example->name);
        $this->assertEquals('New desc', $example->description);
        $this->assertEquals(true, $example->isActive);
    }

    public function testActivated()
    {
        $example = new Example(
            name: 'New Cat',
            isActive: false,
        );

        $this->assertFalse($example->isActive);
        $example->activate();
        $this->assertTrue($example->isActive);
    }

    public function testDisabled()
    {
        $example = new Example(
            name: 'New Cat',
        );

        $this->assertTrue($example->isActive);
        $example->disable();
        $this->assertFalse($example->isActive);
    }

    public function testUpdate()
    {
        $uuid = (string) Uuid::uuid4()->toString();

        $example = new Example(
            id: $uuid,
            name: 'New Cat',
            description: 'New desc',
            isActive: true,
            createdAt: '2023-01-01 12:12:12'
        );

        $example->update(
            name: 'new_name',
            description: 'new_desc',
        );

        $this->assertEquals($uuid, $example->id());
        $this->assertEquals('new_name', $example->name);
        $this->assertEquals('new_desc', $example->description);
    }

    public function testExceptionName()
    {
        try {
            new Example(
                name: 'Na',
                description: 'New Desc'
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testExceptionDescription()
    {
        try {
            new Example(
                name: 'Name Cat',
                description: random_bytes(999999)
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
}
