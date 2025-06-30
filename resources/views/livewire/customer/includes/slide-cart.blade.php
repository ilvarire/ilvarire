<li class="header-cart-item flex-w flex-t m-b-12">
    <div class="header-cart-item-img">
        <button wire:click="removeFromCart('{{ $item->product->id }}')">
            <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}" alt="IMG">
        </button>

    </div>

    <div class="header-cart-item-txt p-t-8">
        <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
            {{ $item->product->name ?? 'N/A'}}
        </a>

        <span class="header-cart-item-info">
            {{ $item->quantity }} x
            ${{ number_format($item->product->price ?? 0, 2)}}

        </span>
    </div>

    <div class="header-cart-item-txt" style="text-align: end; margin-top: -30px;">
        <button wire:click="removeFromCart('{{ $item->product->id }}')">
            X
        </button>
    </div>

</li>