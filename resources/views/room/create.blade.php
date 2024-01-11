<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rooms') }}
        </h2>
    </x-slot>

    @include('room.partials.form', [
        'action' => route('rooms.store')
    ])

</x-app-layout>
