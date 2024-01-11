<?php

namespace App\Repositories\Interfaces;

use App\Models\Room;
use Illuminate\Pagination\LengthAwarePaginator;

interface RoomRepositoryInterface
{
    public function insert(array $data): Room;

    public function findById(string $id): Room;

    public function update(array $data): Room;

    public function delete(string $id): bool;

    public function findAll(string $filter = '', $order = 'DESC'): array;

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): LengthAwarePaginator;
}
