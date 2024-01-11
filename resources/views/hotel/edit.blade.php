<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hotels') }}
        </h2>
    </x-slot>

    @include('hotel.partials.form', [
        'patch' => true,
        'action' => route('hotels.update', $hotel)
    ])

</x-app-layout>
