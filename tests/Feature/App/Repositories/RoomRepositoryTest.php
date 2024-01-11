<?php

namespace App\Repositories;

use App\Models\Hotel;
use App\Models\Room;
use App\Repositories\Eloquent\HotelEloquentRepository;
use App\Repositories\Eloquent\RoomEloquentRepository;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use App\Repositories\Interfaces\RoomRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class RoomRepositoryTest extends TestCase
{
    protected RoomRepositoryInterface $repository;
    protected HotelRepositoryInterface $hotelRepository;

    public function test_insert(): void
    {
        $data = Room::factory()->raw();

        $hotel = $this->repository->insert($data);

        $this->assertInstanceOf(Room::class, $hotel);
        $this->assertEquals($hotel->name, $data['name']);
        $this->assertDatabaseHas('hotels', [
            'name' => $data['name']
        ]);
    }

    public function test_find_by_id(): void
    {
        $data = Room::factory()->create();

        $hotel = $this->repository->findById($data->id);

        $this->assertInstanceOf(Room::class, $hotel);
        $this->assertEquals($hotel->name, $data['name']);
    }

    public function test_find_by_id_fail(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository->findById(1);
    }

    public function test_update(): void
    {
        $data = Room::factory()->create();

        $name = 'Room Bacana';
        $website = 'www.hotel.com';
        $data->name = $name;
        $data->website = $website;

        $hotel = $this->repository->update($data->toArray());

        $this->assertInstanceOf(Room::class, $hotel);
        $this->assertEquals($hotel->name, $name);
        $this->assertEquals($hotel->website, $website);
        $this->assertEquals($hotel->zip_code, $data->zip_code);
    }

    public function test_delete(): void
    {
        $data = Room::factory()->create();

        $hotel = $this->repository->delete($data->id);

        $this->assertTrue($hotel);
    }

    public function test_delete_fail(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository->findById(1);
    }

    public function test_find_all_empty(): void
    {
        $hotels = $this->repository->findAll();

        $this->assertCount(0, $hotels);
    }

    public function test_find_all(): void
    {
        Room::factory(10)->create();

        $hotels = $this->repository->findAll();

        $this->assertCount(10, $hotels);
    }

    public function test_pagination_empty(): void
    {
        $hotels = $this->repository->paginate();

        $this->assertEquals(0, $hotels->total());
    }

    public function test_pagination(): void
    {
        Room::factory(20)->create();

        $hotels = $this->repository->paginate();

        $this->assertCount(15, $hotels->items());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new RoomEloquentRepository(new Room());
        $this->hotelRepository = new HotelEloquentRepository(new Hotel());
    }
}
