<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class HotelControllerTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this
            ->actingAs($this->getUser())
            ->get('/hotels');

        $response->assertOk();
    }

    public function test_create(): void
    {
        $response = $this
            ->actingAs($this->getUser())
            ->get('/hotels');

        $response->assertOk();
    }

    public function test_store(): void
    {
        $data = Hotel::factory()->raw();

        $response = $this
            ->actingAs($this->getUser())
            ->post('/hotels', $data);

        $this->assertDatabaseHas('hotels', $data);
    }

    public function test_store_failed(): void
    {
        $response = $this
            ->actingAs($this->getUser())
            ->post('/hotels', []);

        $response->assertSessionHasErrors();
    }


    public function test_show(): void
    {
        $data = Hotel::factory()->create();

        $response = $this
            ->actingAs($this->getUser())
            ->get("/hotels/{$data->id}");

        $response->assertOk();
    }

    public function test_show_failed(): void
    {
        $response = $this
            ->actingAs($this->getUser())
            ->get('/hotels/1');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_edit(): void
    {
        $data = Hotel::factory()->create();

        $response = $this
            ->actingAs($this->getUser())
            ->get("/hotels/{$data->id}/edit");

        $response->assertOk();
    }

    public function test_update(): void
    {
        $data = Hotel::factory()->create();

        $newData = $data->toArray();
        $newData['name'] = 'Hotel Bacana';

        $this
            ->actingAs($this->getUser())
            ->put("/hotels/{$data->id}", $newData);

        $this->assertDatabaseHas('hotels', [
            'name' => $newData['name']
        ]);
    }

    public function test_delete(): void
    {
        $data = Hotel::factory()->create();

        $this
            ->actingAs($this->getUser())
            ->delete("/hotels/{$data->id}");

        $this->assertDatabaseMissing('hotels', [
            'name' => $data->name
        ]);
    }

    protected function getUser()
    {
        return User::factory()->create();
    }
}
