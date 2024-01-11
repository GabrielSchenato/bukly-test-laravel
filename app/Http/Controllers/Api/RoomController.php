<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Repositories\Interfaces\RoomRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;


class RoomController extends Controller
{
    public function __construct(private readonly RoomRepositoryInterface $repository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $rooms = $this->repository->paginate(
            filter: $request->get('filter', ''),
            order: $request->get('order', 'DESC'),
            totalPage: (int)$request->get('total_page', 15)
        );

        return RoomResource::collection($rooms->collect())->additional([
            'meta' => [
                'total' => $rooms->total(),
                'current_page' => $rooms->currentPage(),
                'last_page' => $rooms->lastPage(),
                'first_page' => $rooms->firstItem(),
                'per_page' => $rooms->perPage(),
                'to' => $rooms->firstItem(),
                'from' => $rooms->lastItem(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request): JsonResponse
    {
        $room = $this->repository->insert($request->validated());

        return RoomResource::make($room)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $room = $this->repository->findById($id);

        return RoomResource::make($room)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, $id): JsonResponse
    {
        $room = $this->repository->update($request->validated());

        return RoomResource::make($room)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): \Illuminate\Http\Response
    {
        $this->repository->delete($id);

        return response()->noContent();
    }
}
