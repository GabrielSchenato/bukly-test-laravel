<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tests\Unit\App\Models\ModelTestCase;

class RoomUnitTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Room();
    }


    protected function traits(): array
    {
        return [
            HasFactory::class
        ];
    }

    protected function fillables(): array
    {
        return [
            'name',
            'description',
            'hotel_id'
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'int'
        ];
    }
}
