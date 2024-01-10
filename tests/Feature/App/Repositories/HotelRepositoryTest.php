<?php

namespace App\Repositories;

use App\Models\Hotel;
use App\Repositories\Eloquent\HotelEloquentRepository;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function test_find_by_id(): void
    {
        $data = Hotel::factory()->create();

        $hotel = $this->repository->findById($data->id);

        $this->assertInstanceOf(Hotel::class, $hotel);
        $this->assertEquals($hotel->name, $data['name']);
    }

    public function test_find_by_id_fail(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository->findById(1);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new HotelEloquentRepository(new Hotel());
    }
}
