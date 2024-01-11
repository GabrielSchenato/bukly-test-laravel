<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class RoomControllerTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this
            ->actingAs($this->getUser())
            ->get('/rooms');

        $response->assertOk();
    }

    public function test_create(): void
    {
        $response = $this
            ->actingAs($this->getUser())
            ->get('/rooms');

        $response->assertOk();
    }

    public function test_store(): void
    {
        $data = Room::factory()->raw();

        $response = $this
            ->actingAs($this->getUser())
            ->post('/rooms', $data);

        $this->assertDatabaseHas('rooms', $data);
    }

    public function test_store_failed(): void
    {
        $response = $this
            ->actingAs($this->getUser())
            ->post('/rooms', []);

        $response->assertSessionHasErrors();
    }


    public function test_show(): void
    {
        $data = Room::factory()->create();

        $response = $this
            ->actingAs($this->getUser())
            ->get("/rooms/{$data->id}");

        $response->assertOk();
    }

    public function test_show_failed(): void
    {
        $response = $this
            ->actingAs($this->getUser())
            ->get('/rooms/1');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_edit(): void
    {
        $data = Room::factory()->create();

        $response = $this
            ->actingAs($this->getUser())
            ->get("/rooms/{$data->id}/edit");

        $response->assertOk();
    }

    public function test_update(): void
    {
        $data = Room::factory()->create();

        $newData = $data->toArray();
        $newData['name'] = 'Room Bacana';

        $this
            ->actingAs($this->getUser())
            ->put("/rooms/{$data->id}", $newData);

        $this->assertDatabaseHas('rooms', [
            'name' => $newData['name']
        ]);
    }

    public function test_delete(): void
    {
        $data = Room::factory()->create();

        $this
            ->actingAs($this->getUser())
            ->delete("/rooms/{$data->id}");

        $this->assertDatabaseMissing('rooms', [
            'name' => $data->name
        ]);
    }

    protected function getUser()
    {
        return User::factory()->create();
    }
}
