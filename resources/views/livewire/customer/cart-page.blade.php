<div>
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="/" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                Cart
            </span>
        </div>
    </div>

    <!-- Shoping Cart -->
    <form wire:submit.prevent class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">Product</th>
                                    <th class="column-2"></th>
                                    <th class="column-3">Price</th>
                                    <th class="column-4">Quantity</th>
                                    <th class="column-5">Total</th>
                                </tr>
                                @forelse ($cartItems as $index => $item)
                                    <tr class="table_row">
                                        {{-- {{dd($item->quantity)}} --}}
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}"
                                                    alt="IMG">
                                            </div>
                                        </td>
                                        <td class="column-2">{{ $item->product->name }}</td>
                                        <td class="column-3">$ {{ number_format($item->product->price, 2) }}</td>
                                        <td class="column-4">
                                            <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>

                                                <input class="mtext-104 cl3 txt-center num-product" type="number" min="1"
                                                    max="200" wire:model.live="quantities.{{$item->product->id}}">

                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="column-5">
                                            $
                                            {{ number_format($item->product->price * (is_array($item->quantity) ? $item->quantity['quantity'] : $item->quantity), 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="table_row">
                                        <td class="column-4">
                                            <p class="stext-111 cl6 p-t-2">
                                                No products in cart.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse

                            </table>
                        </div>

                        <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            <div class="flex-w flex-m m-r-20 m-tb-5">
                                <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text"
                                    name="coupon" wire:model.defer="couponCode" placeholder="Coupon Code">


                                <div wire:click="applyCoupon"
                                    class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                    Apply coupon
                                </div>
                            </div>

                            <div wire:click="updateCart"
                                class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                Update Cart
                            </div><br>
                            @error ('couponCode')
                                <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                            @enderror
                            @if (session('error'))
                                <div class="m-tb-10 p-lr-15 p-tb-2" style="background: #fc5555; border-radius: 6px;">
                                    <h3 class="stext-111 cl6 p-t-2" style="color: white">{{session('error')}}</h3>
                                </div>
                            @endif
                            @if (session('success'))
                                <h3 class="stext-111 cl6 p-t-2" style="color: seagreen">{{session('success')}}</h3>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Cart Totals
                        </h4>

                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
                                <span class="stext-110 cl2">
                                    Subtotal:
                                </span>
                            </div>

                            <div class="size-209">
                                <span class="mtext-110 cl2">
                                    {{-- {{dd($cartTotal)}} --}}
                                    ${{number_format($cartTotal, 2)}}
                                </span>
                            </div>
                        </div>

                        <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                            <div class="size-208 w-full-ssm">
                                <span class="stext-110 cl2">
                                    Shipping:
                                </span>
                            </div>

                            <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                {{-- <p class="stext-111 cl6 p-t-2">
                                    There are no shipping methods available. Please double check your address, or
                                    contact us if you need any help.
                                </p> --}}

                                <div class="p-t-15">
                                    <span class="stext-112 cl8">
                                        Calculate Shipping
                                    </span>

                                    <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                        <select class="jstext-111 cl8 plh3 size-111 p-lr-15"
                                            wire:model.live="selectedCountry" name="time">
                                            <option>Select a country...</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                        @error ('selectedCountry')
                                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                                        @enderror
                                    </div>

                                    @if ($states)
                                        <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                            <select class="stext-111 cl8 plh3 size-111 p-lr-15"
                                                wire:model.live="selectedState" name="time">
                                                <option>Select a state/region...</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state }}">{{ $state }}</option>
                                                @endforeach
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                            @error ('selectedState')
                                                <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                                            @enderror
                                        </div>
                                    @endif

                                    @if ($selectedState)
                                        <div class="bor8 bg0 m-b-22">
                                            <input wire:model.defer="city" class="stext-111 cl8 plh3 size-111 p-lr-15"
                                                type="text" placeholder="City">
                                            @error ('city')
                                                <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                                            @enderror
                                        </div>
                                        <div class="bor8 bg0 m-b-22">
                                            <input wire:model.defer="address" class="stext-111 cl8 plh3 size-111 p-lr-15"
                                                type="text" placeholder="Address">
                                            @error ('address')
                                                <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                                            @enderror
                                        </div>
                                        <div class="bor8 bg0 m-b-22">
                                            <input wire:model.defer="phone_number"
                                                class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" placeholder="phone">
                                            @error ('phone_number')
                                                <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                                            @enderror
                                        </div>
                                        <div class="bor8 bg0 m-b-22">
                                            <input wire:model.defer="zipCode" class="stext-111 cl8 plh3 size-111 p-lr-15"
                                                type="text" name="postcode" placeholder="Postcode / Zip">
                                            @error ('zipCode')
                                                <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                                            @enderror
                                        </div>
                                    @endif
                                    @if ($discount > 0)
                                        <p><strong>Discount:</strong> -${{ number_format($discount, 2) }}</p>
                                    @endif

                                    @if ($shippingFee)
                                        <span class="stext-112 cl8">
                                            Shipping fee: ${{ number_format($shippingFee, 2) }}
                                        </span><br>
                                        <span class="stext-112 cl8">
                                            Total Weight: {{ $totalWeight }}kg
                                        </span>
                                    @endif
                                    {{-- <div class="flex-w">
                                        <div
                                            class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer">
                                            Update Totals
                                        </div>
                                    </div> --}}

                                </div>
                            </div>
                        </div>

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="mtext-101 cl2">
                                    Total:
                                </span>
                            </div>

                            <div class="size-209 p-t-1">
                                <span class="mtext-110 cl2">
                                    ${{number_format($grandTotal, 2)}}
                                </span>
                            </div>
                        </div>

                        <div class="flex-c-m flex-w w-full p-t-10">
                            <svg xmlns="http://www.w3.org/2000/svg" wire:loading width="30px"
                                class="stext-111 cl6 p-t-2" viewBox="0 0 512 512">
                                <path
                                    d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z" />
                            </svg>
                        </div>

                        <button wire:click="checkout" wire:loading.remove
                            class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <livewire:customer.layout.footer />
</div>