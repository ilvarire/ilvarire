<div>
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="/" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                Payments
            </span>
        </div>
    </div>
    <form class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">Order</th>
                                    <th class="column-2"></th>
                                    <th class="column-3">Date/Method</th>
                                    {{-- <th class="column-4">Quantity</th> --}}
                                    <th class="column-5">Status</th>
                                </tr>

                                @forelse ($payments as $payment)
                                    <tr class="table_row">
                                        <td class="column-1">
                                            <a class=""
                                                href="{{ route('orders.show', $payment->order->reference)}}">{{ $payment->order->reference }}
                                            </a>
                                        </td>
                                        <td class="column-3"></td>
                                        <td class="column-3">{{$payment->created_at->format('d-M-y')}} |
                                            {{$payment->payment_method}} {{'($' . number_format($payment->amount, 2) . ')'}}
                                        </td>
                                        <td class="column-5">{{$payment->status}}</td>
                                    </tr>
                                @empty
                                    <tr class="table_row">
                                        <td class="column-4">
                                            <p class="stext-111 cl6 p-t-2">
                                                No Payments found.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse

                            </table>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </form>
    <livewire:customer.layout.footer />
</div>