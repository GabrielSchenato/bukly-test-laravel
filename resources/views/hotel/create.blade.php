<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hotels') }}
        </h2>
    </x-slot>

    @include('hotel.partials.form', [
        'action' => route('hotels.store')
    ])

</x-app-layout>
