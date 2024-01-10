<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

abstract class ModelTestCase extends TestCase
{
    abstract protected function model(): Model;

    abstract protected function traits(): array;

    abstract protected function fillables(): array;

    abstract protected function casts(): array;

    public function test_if_use_traits(): void
    {
        $expected = $this->traits();
        $actual = array_keys(class_uses($this->model()));

        $this->assertEquals($expected, $actual);
    }

    public function test_fillables(): void
    {
        $expected = $this->fillables();
        $actual = $this->model()->getFillable();

        $this->assertEquals($expected, $actual);
    }

    public function test_incrementing_is_true(): void
    {
        $model = $this->model();

        $this->assertTrue($model->incrementing);
    }

    public function test_has_casts(): void
    {
        $expected = $this->casts();
        $actual = $this->model()->getCasts();

        $this->assertEquals($expected, $actual);
    }

}
