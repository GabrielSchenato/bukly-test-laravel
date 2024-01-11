<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="post" action="{{$action}}">
                    @csrf
                    @isset($patch)
                        @method('patch')
                    @endif

                    <x-text-input id="id" name="id" type="hidden" :value="old('id', $hotel?->id)"/>

                    <div class="grid grid-cols-2 gap-6 border-b border-gray-900/10 pb-12"
                         x-data="{ address: {logradouro: '{{old('address', $hotel?->address)}}', localidade: '{{old('city', $hotel?->city)}}', uf: '{{old('state', $hotel?->state)}}', cep: '{{old('zip_code', $hotel?->zip_code)}}'} }">
                        <div>
                            <x-input-label for="name" :value="__('Name')"/>
                            <x-text-input id="name" name="name" type="text"
                                          class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                                          :value="old('name', $hotel?->name)" required autofocus
                                          autocomplete="name"/>
                            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                        </div>

                        <div>
                            <x-input-label for="zip_code" :value="__('Zip Code')"/>
                            <x-text-input id="zip_code" name="zip_code" type="text"
                                          x-model="address.cep" x-on:input.debounce.300ms="checkAndSearchZipCode"
                                          class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                                          :value="old('zip_code', $hotel?->zip_code)" required
                                          autocomplete="zip_code"
                                          placeholder="Enter your zip code to search"/>
                            <x-input-error class="mt-2" :messages="$errors->get('zip_code')"/>
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Address')"/>
                            <x-text-input id="address" name="address" type="text"
                                          x-model="address.logradouro"
                                          class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                                          :value="old('address', $hotel?->address)" required
                                          autocomplete="address"/>
                            <x-input-error class="mt-2" :messages="$errors->get('address')"/>
                        </div>

                        <div>
                            <x-input-label for="city" :value="__('City')"/>
                            <x-text-input id="city" name="city" type="text"
                                          x-model="address.localidade"
                                          class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                                          :value="old('city', $hotel?->city)" required autocomplete="city"/>
                            <x-input-error class="mt-2" :messages="$errors->get('city')"/>
                        </div>

                        <div>
                            <x-input-label for="state" :value="__('State')"/>
                            <x-text-input id="state" name="state" type="text"
                                          x-model="address.uf"
                                          class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                                          :value="old('state', $hotel?->state)" required autocomplete="state"/>
                            <x-input-error class="mt-2" :messages="$errors->get('state')"/>
                        </div>

                        <div>
                            <x-input-label for="website" :value="__('Website')"/>
                            <x-text-input id="website" name="website" type="text"
                                          class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                                          :value="old('website', $hotel?->website)" autocomplete="website"/>
                            <x-input-error class="mt-2" :messages="$errors->get('website')"/>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <a type="button"
                           class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                           href="{{route('hotels.index')}}">Cancel</a>
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function checkAndSearchZipCode() {
            if (/^\d{5}-\d{3}$/.test(this.address.cep) || /^\d{5}\d{3}$/.test(this.address.cep)) {
                fetch(`https://viacep.com.br/ws/${this.address.cep}/json/`)
                    .then(response => response.json())
                    .then(data => this.address = data);
            }
        }
    </script>
@endpush
