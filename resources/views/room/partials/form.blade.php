<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="post" action="{{$action}}">
                    @csrf
                    @isset($patch)
                        @method('patch')
                    @endif

                    <x-text-input id="id" name="id" type="hidden" :value="old('id', $room?->id)"/>

                    <div class="grid grid-cols-2 gap-6 border-b border-gray-900/10 pb-12">
                        <div>
                            <x-input-label for="name" :value="__('Name')"/>
                            <x-text-input id="name" name="name" type="text"
                                          class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                                          :value="old('name', $room?->name)" required autofocus
                                          autocomplete="name"/>
                            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')"/>
                            <x-text-area-input id="description" name="description"
                                               class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                                               required autofocus
                                               autocomplete="description">{{old('description', $room?->description)}}</x-text-area-input>
                            <x-input-error class="mt-2" :messages="$errors->get('description')"/>
                        </div>

                        <div>
                            <x-input-label for="hotel_id" :value="__('Hotel')"/>
                            <select
                                id="hotel_id"
                                name="hotel_id"
                                class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                            >
                                @foreach(\Illuminate\Support\Arr::prepend($hotels, ['id' => null, 'name' => null]) as $hotel)
                                    <option
                                        value="{{$hotel['id']}}"
                                        @selected(old('hotel_id', $room?->hotel_id) == $hotel['id'])
                                    >{{$hotel['name']}}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('hotel_id')"/>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <a type="button"
                           class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                           href="{{route('rooms.index')}}">Cancel</a>
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
