<div wire:key="{{rand()}}" class="{{ $class ?? ''}} {{$product->category->name}}">
    <!-- Block2 -->
    <div class="block2">
        <div class="block2-pic hov-img0"
            style="border-top-left-radius: 25px; border-bottom-right-radius: 25px; filter: drop-shadow(1px 1px 3px rgb(165, 187, 249));">
            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" alt="IMG-PRODUCT">

            <button wire:click="viewProduct('{{ $product->id }}')" @click="showProductModal = true"
                class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                Quick View
            </button>
        </div>

        <div class="block2-txt flex-w flex-t p-t-14">
            <div class="block2-txt-child1 flex-col-l ">
                <a href="{{ route('products.show', $product->slug)}}"
                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                    {{$product->name}}
                </a>

                <span class="stext-105 cl3">
                    ${{ number_format($product->price, 2) }}
                </span>
            </div>

            <div x-data="{open: false}" class="block2-txt-child2 flex-r p-t-3">

                <button style="cursor: pointer;" x-on:click="open = !open; $wire.addToWishlist('{{$product->id}}')"
                    x-bind:style="open ? 'color: black;' : '{{ $this->isInWishlist($product->id) ? 'color: rgb(55, 103, 236)' : ''}}'">
                    <i class="zmdi zmdi-favorite">
                    </i>
                </button>


            </div>


        </div>
    </div>
</div>