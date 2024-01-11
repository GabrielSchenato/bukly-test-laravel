<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Http\Resources\HotelResource;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;


class HotelController extends Controller
{
    public function __construct(private readonly HotelRepositoryInterface $repository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $hotels = $this->repository->paginate(
            filter: $request->get('filter', ''),
            order: $request->get('order', 'DESC'),
            totalPage: (int)$request->get('total_page', 15)
        );

        return HotelResource::collection($hotels->collect())->additional([
            'meta' => [
                'total' => $hotels->total(),
                'current_page' => $hotels->currentPage(),
                'last_page' => $hotels->lastPage(),
                'first_page' => $hotels->firstItem(),
                'per_page' => $hotels->perPage(),
                'to' => $hotels->firstItem(),
                'from' => $hotels->lastItem(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request): JsonResponse
    {
        $hotel = $this->repository->insert($request->validated());

        return HotelResource::make($hotel)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $hotel = $this->repository->findById($id);

        return HotelResource::make($hotel)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, $id): JsonResponse
    {
        $hotel = $this->repository->update($request->validated());

        return HotelResource::make($hotel)
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
