<?php

namespace App\Repositories\Eloquent;

use App\Models\Room;
use App\Repositories\Interfaces\RoomRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomEloquentRepository implements RoomRepositoryInterface
{
    public function __construct(private readonly Room $model)
    {
    }

    public function insert(array $data): Room
    {
        return $this->model->create($data);
    }

    public function findById(string $id): Room
    {
        return $this->model->findOrFail($id);
    }

    public function update(array $data): Room
    {
        $hotel = $this->model->findOrFail($data['id']);
        $hotel->update($data);
        $hotel->refresh();

        return $hotel;
    }

    public function delete(string $id): bool
    {
        $hotel = $this->model->findOrFail($id);

        return $hotel->delete();
    }

    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        $categories = $this->model
            ->when($filter, fn($query) => $query->where('name', 'LIKE', "%{$filter}%"))
            ->orderBy('id', $order)
            ->get();

        return $categories->toArray();
    }

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->when($filter, fn($query) => $query->where('name', 'LIKE', "%{$filter}%"))
            ->orderBy('id', $order)
            ->paginate();
    }
}
