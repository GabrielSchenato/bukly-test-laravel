<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use App\Repositories\Interfaces\RoomRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct(
        private readonly RoomRepositoryInterface  $repository,
        private readonly HotelRepositoryInterface $hotelRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $rooms = $this->repository->paginate(
            filter: $request->get('filter', ''),
            order: $request->get('order', 'DESC'),
            totalPage: (int)$request->get('total_page', 15)
        );

        return view('room.index', compact([
            'rooms'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $room = null;
        $hotels = $this->hotelRepository->findAll();

        return view('room.create', compact([
            'room',
            'hotels'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request): RedirectResponse
    {
        $room = $this->repository->insert($request->validated());

        return response()->redirectToRoute('rooms.show', $room);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $room = $this->repository->findById($id);

        return view('room.show', compact([
            'room'
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $room = $this->repository->findById($id);
        $hotels = $this->hotelRepository->findAll();

        return view('room.edit', compact([
            'room',
            'hotels'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, $id): RedirectResponse
    {
        $room = $this->repository->update($request->validated());

        return response()->redirectToRoute('rooms.show', $room);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $this->repository->delete($id);

        return redirect()->back();
    }
}
