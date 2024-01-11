<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function __construct(private readonly HotelRepositoryInterface $repository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $hotels = $this->repository->paginate(
            filter: $request->get('filter', ''),
            order: $request->get('order', 'DESC'),
            totalPage: (int)$request->get('total_page', 15)
        );

        return view('hotel.index', compact([
            'hotels'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $hotel = null;

        return view('hotel.create', compact([
            'hotel'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request): RedirectResponse
    {
        $hotel = $this->repository->insert($request->validated());

        return response()->redirectToRoute('hotels.show', $hotel);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $hotel = $this->repository->findById($id);

        return view('hotel.show', compact([
            'hotel'
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $hotel = $this->repository->findById($id);

        return view('hotel.edit', compact([
            'hotel'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, $id): RedirectResponse
    {
        $hotel = $this->repository->update($request->validated());

        return response()->redirectToRoute('hotels.show', $hotel);
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
