<div x-data="{ showModal: false, action: '', shippingRateId: null }" x-on:modal-close.window="showModal = false">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        All Shipping Rates
    </h2>
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        @if (session()->has('success'))
            <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                href="{{route('admin.rates.add')}}">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                        </path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <span>Add shipping rates &RightArrow;</span>
            </a>
        @endif
        <!-- Search input -->
        <div class="flex justify-between my-6 flex-1 lg:mr-32">
            <div>
                <button wire:click="$set('search', '')"
                    class="flex items-center justify-between mt-1 ml-4 px-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    aria-label="Like">
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 512 512">
                        <path
                            d="M48.5 224L40 224c-13.3 0-24-10.7-24-24L16 72c0-9.7 5.8-18.5 14.8-22.2s19.3-1.7 26.2 5.2L98.6 96.6c87.6-86.5 228.7-86.2 315.8 1c87.5 87.5 87.5 229.3 0 316.8s-229.3 87.5-316.8 0c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0c62.5 62.5 163.8 62.5 226.3 0s62.5-163.8 0-226.3c-62.2-62.2-162.7-62.5-225.3-1L185 183c6.9 6.9 8.9 17.2 5.2 26.2s-12.5 14.8-22.2 14.8L48.5 224z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="relative w-xs max-w-xl mr-6 focus-within:text-purple-500">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input wire:model.live.debounce.500ms="search"
                    class="w-full pl-8 mt-1 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                    type="text" placeholder="Search by state" aria-label="Search" />
            </div>
            <select wire:model.live="selectedCountry"
                class="block w-xs mt-1  mr-6 text-sm dark:text-gray-300 border-0 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="">All Countries</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>

        </div>
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Country</th>
                        <th class="px-4 py-3">State</th>
                        <th class="px-4 py-3">Fee Per Kg</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($shippingRates as $shippingRate)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <!-- Avatar with inset shadow -->

                                    <div>
                                        <p class="font-semibold"> {{$shippingRate->country->name}} </p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            ${{ number_format($shippingRate->base_fee, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$shippingRate->state}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                ${{ number_format($shippingRate->fee_per_kg, 2) }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <button wire:click="edit({{ $shippingRate->id }})"
                                        @click="action = 'edit'; shippingRateId = {{ $shippingRate->id }}; showModal = true"
                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Edit">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                            </path>
                                        </svg>

                                    </button>
                                    <button
                                        @click="action = 'delete'; $wire.set('deleteId', {{ $shippingRate->id }}); shippingRateId = {{ $shippingRate->id }}; showModal = true"
                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Delete">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <span class="flex items-center col-span-3">
                                        No Shipping Rates found
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>
        <div
            class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
            <span class="flex items-center col-span-3">
                @if ($shippingRates->total() > 0)
                    Showing {{ $shippingRates->firstItem() }}-{{ $shippingRates->LastItem() }} of
                    {{ $shippingRates->total() }}
                @else

                @endif

            </span>
            <span class="col-span-2"></span>
            <!-- Pagination -->
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">

                {{ $shippingRates->links() }}
            </span>
        </div>
    </div>
    <!-- Modal backdrop. This what you want to place close to the closing body tag -->
    <div x-show="showModal" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
        style="padding-top: 10px;padding-bottom: 10px;">

        <!-- Modal -->
        <div x-show="showModal" x-transition:enter="transition ease-out duration-150" x-cloak
            x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="showModal = false"
            @keydown.escape="showModal = false"
            class="w-full  h-full overflow-y-auto px-6 py-6 bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
            role="dialog" id="modal">
            <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
            <header class="flex justify-end">
                <button
                    class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                    aria-label="close" @click="showModal = false">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                        <path
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </button>
            </header>
            <!-- Modal body -->
            <div class="mt-4 mb-6">
                <template x-if="action === 'edit'">
                    <div>
                        <!-- Modal title -->
                        <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                            Edit Shipping Rate
                        </p>

                        <!-- Modal description -->
                        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                            <form wire:submit.prevent="updateShippingRate" id="update_shipping_rate">
                                {{-- @csrf --}}
                                <label class="block text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-400">
                                        Country
                                    </span>
                                    <select wire:model="country_id" value="{{ old('country_id') }}"
                                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                        <option class="" value="">select country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <span class="text-xs text-red-600 dark:text-red-400">
                                            {{$message}}
                                        </span>
                                    @enderror

                                </label>

                                <label class="block text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-400">
                                        State
                                    </span>
                                    <input type="text" wire:model="state" value="{{ old('state') }}"
                                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="State" required />
                                    @error('state')
                                        <span class="text-xs text-red-600 dark:text-red-400">
                                            {{$message}}
                                        </span>
                                    @enderror

                                </label>

                                <label class="block text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-400">
                                        Base Fee
                                    </span>
                                    <input type="text" wire:model="base_fee" value="{{ old('base_fee') }}"
                                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="Base Fee" required />
                                    @error('base_fee')
                                        <span class="text-xs text-red-600 dark:text-red-400">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </label>

                                <label class="block text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-400">
                                        Fee per Kg
                                    </span>
                                    <input type="text" wire:model="fee_per_kg" value="{{ old('fee_per_kg') }}"
                                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="00.00" required />
                                    @error('fee_per_kg')
                                        <span class="text-xs text-red-600 dark:text-red-400">
                                            {{$message}}
                                        </span>
                                    @enderror

                                </label>

                            </form>
                        </div>

                        <footer
                            class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">

                            <button @click="showModal = false"
                                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                                Cancel
                            </button>
                            <button type="submit" form="update_shipping_rate"
                                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Save
                            </button>
                        </footer>
                    </div>
                </template>
                <template x-if="action === 'delete'">
                    <div>
                        <!-- Modal title -->
                        <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                            Confirm delete
                        </p>

                        <!-- Modal description -->
                        <p class="text-sm text-gray-700 dark:text-gray-400">
                            Are you sure want to delete this shipping rate?<br>
                            Click ok to confirm
                        </p>

                        <footer
                            class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                            <button @click="showModal = false" type="button"
                                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                                Cancel
                            </button>
                            <button @click="$wire.deleteShippingRate; showModal = false"
                                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Ok
                            </button>


                        </footer>
                    </div>

                </template>

            </div>

        </div>
    </div>
    <!-- End of modal backdrop -->
</div>