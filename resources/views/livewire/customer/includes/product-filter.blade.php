<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
    <div class="filter-col1 p-r-15 p-b-27">
        <div class="mtext-102 cl2 p-b-15">
            Sort By
        </div>

        <ul>
            <li class="p-b-6">
                <button wire:click="setSort('default')" @class([
                    'filter-link stext-106 trans-04 filter-link-active' => $sort === 'default',
                    'filter-link stext-106 trans-04' => $sort !== 'default',
                ])>
                    Default
                </button>
            </li>

            <li class="p-b-6">
                <button wire:click="setSort('popularity')" @class([
                    'filter-link stext-106 trans-04 filter-link-active' => $sort === 'popularity',
                    'filter-link stext-106 trans-04' => $sort !== 'popularity',
                ])>
                    Popularity
                </button>
            </li>

            <li class="p-b-6">
                <button wire:click="setSort('newness')" @class([
                    'filter-link stext-106 trans-04 filter-link-active' => $sort === 'newness',
                    'filter-link stext-106 trans-04' => $sort !== 'newness',
                ])>
                    Newness
                </button>
            </li>

            <li class="p-b-6">
                <button wire:click="setSort('price_low_high')" @class([
                    'filter-link stext-106 trans-04 filter-link-active' => $sort === 'price_low_high',
                    'filter-link stext-106 trans-04' => $sort !== 'price_low_high',
                ])>
                    Price: Low to High
                </button>
            </li>

            <li class="p-b-6">
                <button wire:click="setSort('price_high_low')" @class([
                    'filter-link stext-106 trans-04 filter-link-active' => $sort === 'price_high_low',
                    'filter-link stext-106 trans-04' => $sort !== 'price_high_low',
                ])>
                    Price: High to Low
                </button>
            </li>
        </ul>
    </div>

    <div class="filter-col2 p-r-15 p-b-27">
        <div class="mtext-102 cl2 p-b-15">
            Price
        </div>

        <ul>
            <li class="p-b-6">
                <button wire:click="setPriceRange('{{null}}')" @class([
                    'filter-link stext-106 trans-04 filter-link-active' => $priceRange === null,
                    'filter-link stext-106 trans-04' => $priceRange !== null,
                ])>
                    All
                </button>
            </li>

            <li class="p-b-6">
                <button wire:click="setPriceRange('0-50')" @class([
                    'filter-link stext-106 trans-04 filter-link-active' => $priceRange === '0-50',
                    'filter-link stext-106 trans-04' => $priceRange !== '0-50',
                ])>
                    $0.00 - $50.00
                </button>
            </li>

            <li class="p-b-6">
                <button wire:click="setPriceRange('50-100')" @class([
                    'filter-link stext-106 trans-04 filter-link-active' => $priceRange === '50-100',
                    'filter-link stext-106 trans-04' => $priceRange !== '50-100',
                ])>
                    $50.00 - $100.00
                </button>
            </li>

            <li class="p-b-6">
                <button wire:click="setPriceRange('100-150')" @class([
                    'filter-link stext-106 trans-04 filter-link-active' => $priceRange === '100-150',
                    'filter-link stext-106 trans-04' => $priceRange !== '100-150',
                ])>
                    $100.00 - $150.00
                </button>
            </li>

            <li class="p-b-6">
                <button wire:click="setPriceRange('150-200')" @class([
                    'filter-link stext-106 trans-04 filter-link-active' => $priceRange === '150-200',
                    'filter-link stext-106 trans-04' => $priceRange !== '150-200',
                ])>
                    $150.00 - $200.00
                </button>
            </li>

            <li class="p-b-6">
                <button wire:click="setPriceRange('200+')" @class([
                    'filter-link stext-106 trans-04 filter-link-active' => $priceRange === '200+',
                    'filter-link stext-106 trans-04' => $priceRange !== '200+',
                ])>
                    $200.00+
                </button>
            </li>
        </ul>
    </div>

    {{-- <div class="filter-col3 p-r-15 p-b-27">
        <div class="mtext-102 cl2 p-b-15">
            Color
        </div>

        <ul>
            <li class="p-b-6">
                <span class="fs-15 lh-12 m-r-6" style="color: #222;">
                    <i class="zmdi zmdi-circle"></i>
                </span>

                <a href="#" class="filter-link stext-106 trans-04">
                    Black
                </a>
            </li>

            <li class="p-b-6">
                <span class="fs-15 lh-12 m-r-6" style="color: #4272d7;">
                    <i class="zmdi zmdi-circle"></i>
                </span>

                <a href="#" class="filter-link stext-106 trans-04 filter-link-active">
                    Blue
                </a>
            </li>

            <li class="p-b-6">
                <span class="fs-15 lh-12 m-r-6" style="color: #b3b3b3;">
                    <i class="zmdi zmdi-circle"></i>
                </span>

                <a href="#" class="filter-link stext-106 trans-04">
                    Grey
                </a>
            </li>

            <li class="p-b-6">
                <span class="fs-15 lh-12 m-r-6" style="color: #00ad5f;">
                    <i class="zmdi zmdi-circle"></i>
                </span>

                <a href="#" class="filter-link stext-106 trans-04">
                    Green
                </a>
            </li>

            <li class="p-b-6">
                <span class="fs-15 lh-12 m-r-6" style="color: #fa4251;">
                    <i class="zmdi zmdi-circle"></i>
                </span>

                <a href="#" class="filter-link stext-106 trans-04">
                    Red
                </a>
            </li>

            <li class="p-b-6">
                <span class="fs-15 lh-12 m-r-6" style="color: #aaa;">
                    <i class="zmdi zmdi-circle-o"></i>
                </span>

                <a href="#" class="filter-link stext-106 trans-04">
                    White
                </a>
            </li>
        </ul>
    </div> --}}

    <div class="filter-col4 p-b-27">
        <div class="mtext-102 cl2 p-b-15">
            Tags
        </div>

        <div class="flex-w p-t-4 m-r--5">
            @forelse ($tags as $t)
                <button wire:click="setTag('{{ $t->name }}')" @class([
                    'flex-c-m stext-107 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5' => $tag === $t->name,
                    'flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5' => $tag !== $t->name,
                ])>
                    {{$t->name}}
                </button>
            @empty
            @endforelse

        </div>
    </div>
</div>