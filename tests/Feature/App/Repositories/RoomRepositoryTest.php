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

        $room = $this->repository->insert($data);

        $this->assertInstanceOf(Room::class, $room);
        $this->assertEquals($room->name, $data['name']);
        $this->assertDatabaseHas('rooms', [
            'name' => $data['name']
        ]);
    }

    public function test_find_by_id(): void
    {
        $data = Room::factory()->create();

        $room = $this->repository->findById($data->id);

        $this->assertInstanceOf(Room::class, $room);
        $this->assertEquals($room->name, $data['name']);
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
        $description = 'Description';
        $data->name = $name;
        $data->description = $description;

        $room = $this->repository->update($data->toArray());

        $this->assertInstanceOf(Room::class, $room);
        $this->assertEquals($room->name, $name);
        $this->assertEquals($room->description, $description);
        $this->assertEquals($room->hotel_id, $data->hotel_id);
    }

    public function test_delete(): void
    {
        $data = Room::factory()->create();

        $room = $this->repository->delete($data->id);

        $this->assertTrue($room);
    }

    public function test_delete_fail(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository->findById(1);
    }

    public function test_find_all_empty(): void
    {
        $rooms = $this->repository->findAll();

        $this->assertCount(0, $rooms);
    }

    public function test_find_all(): void
    {
        Room::factory(10)->create();

        $rooms = $this->repository->findAll();

        $this->assertCount(10, $rooms);
    }

    public function test_pagination_empty(): void
    {
        $rooms = $this->repository->paginate();

        $this->assertEquals(0, $rooms->total());
    }

    public function test_pagination(): void
    {
        Room::factory(20)->create();

        $rooms = $this->repository->paginate();

        $this->assertCount(15, $rooms->items());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new RoomEloquentRepository(new Room());
        $this->roomRepository = new HotelEloquentRepository(new Hotel());
    }
}
