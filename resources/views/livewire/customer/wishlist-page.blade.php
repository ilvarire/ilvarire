<div>
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="/" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                Wishlist
            </span>
        </div>
    </div>

    <!-- Shoping Cart -->
    <form class="bg0 p-t-75 p-b-85">
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
                                </tr>

                                @forelse ($wishlistItems as $index => $item)
                                    <tr class="table_row">
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}"
                                                    alt="IMG">
                                            </div>
                                        </td>
                                        <td class="column-2"><a class="stext-111 cl6 p-t-2"
                                                href="{{ route('products.show', $item->product->slug)}}">{{ $item->product->name }}</a>
                                        </td>
                                        <td class="column-3">$ {{ number_format($item->product->price, 2) }}</td>

                                    </tr>
                                @empty
                                    <tr class="table_row">
                                        <td class="column-4">
                                            <p class="stext-111 cl6 p-t-2">
                                                No items in wishlist.
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