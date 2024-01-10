<?php

namespace App\Repositories\Interfaces;

use App\Models\Hotel;
use Illuminate\Pagination\LengthAwarePaginator;

interface HotelRepositoryInterface
{
    public function insert(array $data): Hotel;

    public function findById(string $id): Hotel;

    public function update(array $data): Hotel;

    public function delete(string $id): bool;

    public function findAll(string $filter = '', $order = 'DESC'): array;

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): LengthAwarePaginator;
}
