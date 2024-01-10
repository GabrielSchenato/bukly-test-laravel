<?php

namespace App\Repositories;

use App\Models\Hotel;
use App\Repositories\Eloquent\HotelEloquentRepository;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use Tests\TestCase;

class HotelRepositoryTest extends TestCase
{
    protected HotelRepositoryInterface $repository;

    public function test_insert(): void
    {
        $data = Hotel::factory()->raw();

        $hotel = $this->repository->insert($data);

        $this->assertInstanceOf(Hotel::class, $hotel);
        $this->assertEquals($hotel->name, $data['name']);
        $this->assertDatabaseHas('hotels', [
            'name' => $data['name']
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new HotelEloquentRepository(new Hotel());
    }
}
