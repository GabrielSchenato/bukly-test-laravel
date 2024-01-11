<?php

namespace Api;

use App\Models\Hotel;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class HotelApiTest extends TestCase
{
    protected string $endpoint = '/api/hotels';

    public function test_list_empty_all_hotels(): void
    {
        $response = $this->getJson($this->endpoint);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(0, 'data');
    }

    public function test_list_all_hotels(): void
    {
        Hotel::factory()->count(30)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'last_page',
                'first_page',
                'per_page',
                'to',
                'from',
            ]
        ]);
        $response->assertJsonCount(15, 'data');
    }

    public function test_list_paginate_hotels(): void
    {
        Hotel::factory()->count(25)->create();

        $response = $this->getJson("$this->endpoint?page=2");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'current_page',
                'last_page',
                'first_page',
                'per_page',
                'to',
                'from',
            ]
        ]);
        $this->assertEquals(2, $response['meta']['current_page']);
        $this->assertEquals(25, $response['meta']['total']);
        $response->assertJsonCount(10, 'data');
    }

    public function test_list_hotel_not_found(): void
    {
        $response = $this->getJson("$this->endpoint/fake_value");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_list_hotel(): void
    {
        $hotel = Hotel::factory()->create();

        $response = $this->getJson("$this->endpoint/{$hotel->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'address',
                'city',
                'state',
                'zip_code',
                'website',
                'created_at',
                'updated_at',
            ]
        ]);
        $this->assertEquals($hotel->id, $response['data']['id']);
    }

    public function test_validations_store(): void
    {
        $data = [];

        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
                'address',
                'city',
                'state',
                'zip_code',
            ]
        ]);
    }

    public function test_store(): void
    {
        $data = Hotel::factory()->raw();

        $response = $this->postJson($this->endpoint, $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'address',
                'city',
                'state',
                'zip_code',
                'website',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    public function test_not_found_update(): void
    {
        $id = 'fake_value';
        $data = Hotel::factory()->raw();
        $data['id'] = $id;
        $response = $this->putJson("$this->endpoint/{$id}", $data);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_validations_update(): void
    {
        $data = [
            'name' => ''
        ];

        $response = $this->putJson("$this->endpoint/fake_value", $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'id',
                'name',
                'address',
                'city',
                'state',
                'zip_code'
            ]
        ]);
    }

    public function test_update(): void
    {
        $hotel = Hotel::factory()->create();

        $data = $hotel->toArray();
        $data['name'] = 'Teste';

        $response = $this->putJson("{$this->endpoint}/{$hotel->id}", $data);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'address',
                'city',
                'state',
                'zip_code',
                'website',
                'created_at',
                'updated_at',
            ]
        ]);

        $this->assertEquals($data['name'], $response['data']['name']);
        $this->assertDatabaseHas('hotels', [
            'name' => $data['name']
        ]);
    }

    public function test_not_found_delete(): void
    {
        $response = $this->deleteJson("$this->endpoint/fake_value");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_delete(): void
    {
        $hotel = Hotel::factory()->create();

        $response = $this->deleteJson("$this->endpoint/$hotel->id");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('hotels', [
            'id' => $hotel->id
        ]);
    }

}
