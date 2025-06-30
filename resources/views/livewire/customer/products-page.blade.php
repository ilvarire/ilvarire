<div x-data="{ showProductModal: false, showSearchBox: false}" x-on:openProductModal.window="showProductModal = true"
    x-on:closeProductModal.window="showProductModal = false">
    <section class="bg0 p-t-23 p-b-140">
        <div class="container">
            <div class="flex-w flex-sb-m p-b-52">
                <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    <button wire:click="setCategory('')" @class([
                        'stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1' => $category === null,
                        'stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5' => $category !== null,
                    ]) data-filter="*">
                        All Products
                    </button>
                    @include('livewire.customer.includes.product-categories')
                </div>


                <div class="flex-w flex-c-m m-tb-10">
                    <div
                        class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                        <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                        <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Filter
                    </div>

                    <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search"
                        @click="showSearchBox = true">
                        <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Search
                    </div>
                </div>

                <!-- Search product -->
                <div class="panel-search w-full p-t-10 p-b-15" x-show="showSearchBox">
                    @include('livewire.customer.includes.search-product-input')
                </div>

                <!-- Filter -->
                <div class="dis-none panel-filter w-full p-t-10">
                    @include('livewire.customer.includes.product-filter')
                </div>
            </div>
            {{-- <div class="flex-c-m flex-w w-full p-t-10">
                <svg xmlns="http://www.w3.org/2000/svg" wire:loading width="30px" class="stext-111 cl6 p-t-2"
                    viewBox="0 0 512 512">
                    <path
                        d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z" />
                </svg>

            </div> --}}
            <!-- Product cards -->
            <div class="row isotope-grid">

                @forelse ($products as $product)
                    @include('livewire.customer.includes.product-card', ['class' => 'col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item'])
                @empty
                    <p class="stext-111 cl6 p-t-2">no products found</p>
                @endforelse

            </div>
            @if ($products->hasMorePages())
                <!-- Load more -->
                <div class="flex-c-m flex-w w-full p-t-45">
                    <button wire:click="loadMore"
                        class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                        See More
                    </button>
                </div>
            @endif
        </div>
    </section>
    <!-- Footer -->

    <livewire:customer.layout.footer />

    <!-- Modal1 -->
    <div class="wrap-modal1 js-modal1 show-modal1 p-t-60 p-b-20" x-show="showProductModal">
        <div class="overlay-modal1 js-hide-modal1"></div>
        @include('livewire.customer.includes.product-modal')

    </div>

    <script>


        window.addEventListener('reinitmodal', () => {
            setTimeout(() => {
                $(".js-select2").each(function () {
                    $(this).select2({
                        minimumResultsForSearch: 20,
                        dropdownParent: $(this).next('.dropDownSelect2')
                    });
                });

                $('.wrap-slick3').each(function () {
                    $(this).find('.slick3').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        fade: true,
                        infinite: true,
                        autoplay: false,
                        autoplaySpeed: 6000,

                        arrows: true,
                        appendArrows: $(this).find('.wrap-slick3-arrows'),
                        prevArrow: '<button class="arrow-slick3 prev-slick3"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
                        nextArrow: '<button class="arrow-slick3 next-slick3"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',

                        dots: true,
                        appendDots: $(this).find('.wrap-slick3-dots'),
                        dotsClass: 'slick3-dots',
                        customPaging: function (slick, index) {
                            var portrait = $(slick.$slides[index]).data('thumb');
                            return '<img src=" ' + portrait + ' "/><div class="slick3-dot-overlay"></div>';
                        },
                    });
                });

                $('.js-addwish-b2').on('click', function (e) {
                    e.preventDefault();
                });

                $('.js-addwish-b2').each(function () {
                    var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
                    $(this).on('click', function () {
                        swal(nameProduct, "is added to wishlist !", "success");

                        $(this).addClass('js-addedwish-b2');
                        $(this).off('click');
                    });
                });

                $('.js-addwish-detail').each(function () {
                    var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

                    $(this).on('click', function () {
                        swal(nameProduct, "is added to wishlist !", "success");

                        $(this).addClass('js-addedwish-detail');
                        $(this).off('click');
                    });
                });

                /*---------------------------------------------*/

                $('.js-addcart-detail').each(function () {
                    var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
                    $(this).on('click', function () {
                        swal(nameProduct, "is added to cart !", "success");
                    });
                });

                /*==================================================================
                    [ +/- num product ]*/
                $(".btn-num-product-down").on("click", function () {
                    var numProduct = Number($(this).next().val());
                    if (numProduct > 0)
                        $(this)
                            .next()
                            .val(numProduct - 1);
                });

                $(".btn-num-product-up").on("click", function () {
                    var numProduct = Number($(this).prev().val());
                    $(this)
                        .prev()
                        .val(numProduct + 1);
                });

            }, 10);
        })
    </script>
</div>