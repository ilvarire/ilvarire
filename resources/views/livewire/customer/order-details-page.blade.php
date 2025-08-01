<div>
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="/" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <a href="{{route('orders')}}" class="stext-109 cl8 hov-cl1 trans-04">
                Orders
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                {{$order->reference}}
            </span>
        </div>
    </div>
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
                                @forelse ($order->orderItems as $item)
                                    <tr class="table_row">
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}"
                                                    alt="IMG">
                                            </div>
                                        </td>
                                        <td class="column-2">{{ $item->product->name }}</td>
                                        <td class="column-3">$ {{ number_format($item->price, 2) }}</td>
                                        <td class="column-4">
                                            <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">

                                                </div>

                                                <input class="mtext-104 cl3 txt-center num-product" type="number" min="1"
                                                    max="200" value="{{$item->quantity}}" disabled>

                                                <div class="cl8 hov-btn3 trans-04 flex-c-m">

                                                </div>
                                            </div>
                                        </td>
                                        <td class="column-5">
                                            $
                                            {{ number_format($item->price * $item->quantity, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="table_row">
                                        <td class="column-4">
                                            <p class="stext-111 cl6 p-t-2">
                                                No products in order.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse

                            </table>
                        </div>

                        <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            <div class="size-208">
                                <span class="stext-110 cl2">
                                    Status: {{$order->status}}<br>
                                    <p class="stext-111 cl6 p-t-2">
                                        {{$order->updated_at->format('d/m/y')}}
                                    </p>
                                </span>
                            </div>
                            @if($order->coupon_id)
                                <h5 class="cl6 p-t-2" style="color: seagreen">
                                    <strong>Discount: </strong>{{$order->coupon->discount_percentage . '% off'}}
                                </h5>
                            @endif

                        </div>

                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Order Total
                        </h4>

                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
                                <span class="stext-110 cl2">
                                    Total Payment:
                                </span>
                            </div>

                            <div class="size-209">
                                <span class="mtext-110 cl2">
                                    {{-- {{dd($cartTotal)}} --}}
                                    ${{number_format($order->total_price, 2)}}
                                    <p class="stext-111 cl6 p-t-2">
                                        {{$order->payment->status}}
                                        {{ '(' . $order->payment->updated_at->format('d/m/y') . ')'}}
                                    </p>
                                </span>
                            </div>
                        </div>

                        <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                            <div class="size-208 w-full-ssm">
                                <span class="stext-110 cl2">
                                    Shipping Info:
                                </span>
                            </div>

                            <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                <p class="stext-111 cl6 p-t-2">
                                    <strong>Country:</strong>
                                    {{ $order->shippingAddress->shippingFee->country->name}}<br>
                                    <strong>State:</strong> {{ $order->shippingAddress->shippingFee->state}}<br>
                                    <strong>City:</strong> {{ $order->shippingAddress->city}}<br>
                                    {{$order->shippingAddress->address}}
                                    <strong>Zip Code:</strong> {{ $order->shippingAddress->zip_code ?? 'n/a'}}<br>

                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <livewire:customer.layout.footer />
</div>