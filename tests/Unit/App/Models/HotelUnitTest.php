<?php

namespace Tests\Unit\App\Models;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelUnitTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Hotel();
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
            'address',
            'city',
            'state',
            'zip_code',
            'website',
        ];
    }

    protected function casts(): array
    {
        return [
            'id' => 'int'
        ];
    }
}
