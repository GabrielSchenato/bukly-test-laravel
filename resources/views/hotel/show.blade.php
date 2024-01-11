<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hotels') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-2 gap-6 border-b border-gray-900/10 pb-12">
                        <div>
                            <x-input-label for="name" :value="__('Name')"
                                           class="!text-lg font-medium text-gray-900 dark:text-gray-100"/>
                            <p>{{$hotel->name}}</p>
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Address')"
                                           class="!text-lg font-medium text-gray-900 dark:text-gray-100"/>
                            <p>{{$hotel->address}}</p>
                        </div>

                        <div>
                            <x-input-label for="city" :value="__('City')"
                                           class="!text-lg font-medium text-gray-900 dark:text-gray-100"/>
                            <p>{{$hotel->city}}</p>
                        </div>

                        <div>
                            <x-input-label for="state" :value="__('State')"
                                           class="!text-lg font-medium text-gray-900 dark:text-gray-100"/>
                            <p>{{$hotel->state}}</p>
                        </div>

                        <div>
                            <x-input-label for="zip_code" :value="__('Zip Code')"
                                           class="!text-lg font-medium text-gray-900 dark:text-gray-100"/>
                            <p>{{$hotel->zip_code}}</p>
                        </div>

                        <div>
                            <x-input-label for="website" :value="__('Website')"
                                           class="!text-lg font-medium text-gray-900 dark:text-gray-100"/>
                            <p>{{$hotel->website}}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <a type="button"
                           class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                           href="{{route('hotels.index')}}">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
