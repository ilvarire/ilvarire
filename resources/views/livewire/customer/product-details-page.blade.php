<div x-data="{ showProductModal: false, showSearchBox: false}" x-on:openProductModal.window="showProductModal = true"
    x-on:closeProductModal.window="showProductModal = false">
    <!-- Product Detail -->
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-dots"></div>
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                            <div class="slick3 gallery-lb">
                                @foreach($product->images as $image)
                                    <div class="item-slick3" wire:key="{{rand()}}"
                                        data-thumb="{{ asset('storage/' . $image->image_url) }}">
                                        <div class="wrap-pic-w pos-relative">
                                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="IMG-PRODUCT">

                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                href="{{ asset('storage/' . $image->image_url) }}">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            {{ $product->name}}
                        </h4>

                        <span class="mtext-106 cl2">
                            ${{ number_format($product->price, 2) }}
                        </span>

                        <p class="stext-102 cl3 p-t-23">
                            {{ $product->brief}}
                        </p>

                        <!--  -->
                        <div class="p-t-33">
                            {{-- <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">
                                    Size
                                </div>

                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select class="js-select2" name="time">
                                            <option>Choose an option</option>
                                            <option>Size S</option>
                                            <option>Size M</option>
                                            <option>Size L</option>
                                            <option>Size XL</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">
                                    Color
                                </div>

                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select class="js-select2" name="time">
                                            <option>Choose an option</option>
                                            <option>Red</option>
                                            <option>Blue</option>
                                            <option>White</option>
                                            <option>Grey</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">
                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>

                                        <input class="mtext-104 cl3 txt-center num-product" min="1" max="200"
                                            type="number" name="num-product" value="1" wire:model="quantity">

                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>

                                    <button wire:click="addToCart('{{ $product->id }}')"
                                        class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                        Add to cart
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                        <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                            <div x-data="{open: false}" class="flex-m bor9 p-r-10 m-r-11">
                                <button style="cursor: pointer; color: rgb(55, 103, 236);"
                                    x-on:click="open = !open; $wire.addToWishlist('{{$product->id}}')"
                                    x-bind:style="open ? 'color: black;' : '{{ $this->isInWishlist($product->id) ? 'color: rgb(55, 103, 236)' : ''}}'">
                                    <i class="zmdi zmdi-favorite">
                                    </i>
                                </button>
                            </div>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                data-tooltip="Google Plus">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bor10 m-t-50 p-t-43 p-b-40">
                <!-- Tab01 -->
                <div class="tab01">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item p-b-10">
                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional
                                information</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews
                                ({{$reviews->count()}})</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-t-43">
                        <!-- - -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="how-pos2 p-lr-15-md">
                                <p class="stext-102 cl6">
                                    {{ $product->description}}
                                </p>
                                <br>
                                @if (session()->has('success'))
                                    <p class="stext-102 cl6" style="color: seagreen">
                                        {{session('success')}}
                                    </p>
                                @endif
                                @error('rating')
                                    <p class="stext-102" style="color:brown">{{ $message }}</p>
                                @enderror
                                @error('message')
                                    <p class="stext-102" style="color:brown">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <!-- - -->
                        <div class="tab-pane fade" id="information" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <ul class="p-lr-28 p-lr-15-sm">
                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Weight
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                {{ $product->weight}} kg
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Dimensions
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                {{ $product->dimensions}}
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Materials
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                {{ $product->materials}}
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Color
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                Black, Blue, Grey, Green, Red, White
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Size
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                XL, L, M, S
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- - -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <div class="p-b-30 m-lr-15-sm">
                                        <!-- Review -->
                                        <div class="flex-w flex-t p-b-68">
                                            @forelse ($reviews as $review)
                                                <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                                    <img src="{{ asset('/images/user.png')}}" alt="AVATAR">
                                                </div>
                                                <div class="size-207">
                                                    <div class="flex-w flex-sb-m p-b-17">
                                                        <span class="mtext-107 cl2 p-r-20">
                                                            {{$review->user->name}}
                                                        </span>

                                                        <span class="fs-18 cl11">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="zmdi zmdi-star {{$i <= $review->rating ? '' : 'c16'}}"></i>
                                                            @endfor

                                                            {{-- <i class="zmdi zmdi-star-half"></i> --}}
                                                        </span>
                                                    </div>

                                                    <p class="stext-102 cl6">
                                                        {{ $review->comment }}
                                                    </p>
                                                </div>
                                            @empty
                                                <p class="stext-102 cl6">
                                                    No reviews yet
                                                </p>
                                            @endforelse
                                        </div>
                                        @if ($canReview)
                                            <!-- Add review -->

                                            <h5 class="mtext-108 cl2 p-b-7">
                                                Add a review
                                            </h5>

                                            <div class="flex-w flex-m p-t-50 p-b-23"
                                                x-data="{ rating: @entangle('rating') }">
                                                <span class="stext-102 cl3 m-r-16">
                                                    Your Rating
                                                </span>

                                                <span class="wrap-rating fs-18 cl11 pointer" wire:ignore>

                                                    <template x-for="star in 5">
                                                        <i @click="rating = star"
                                                            :style="rating >= star ? 'color: yellow' : ''"
                                                            class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                    </template>
                                                    <input class="dis-none" type="number" name="rating">
                                                </span>
                                            </div>

                                            <div class="row p-b-25">
                                                <div class="col-12 p-b-5">
                                                    <label class="stext-102 cl3" for="review">Your review</label>
                                                    <textarea wire:model.defer="message"
                                                        class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review"
                                                        name="review"></textarea>
                                                </div>
                                            </div>
                                            <button wire:click="submitReview"
                                                class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                                Submit
                                            </button>
                                        @else
                                        @endif

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
            <span class="stext-107 cl6 p-lr-25">
                Tags:
                @forelse($product->tags as $tag)
                    {{$tag->name}},
                @empty
                    n/a
                @endforelse
            </span>

            <span class="stext-107 cl6 p-lr-25">
                Category: {{ $product->category->name}}
            </span>
        </div>
    </section>

    <!-- Related Products -->
    <section class="sec-relate-product bg0 p-t-45 p-b-105">
        <div class="container">
            <div class="p-b-45">
                <h3 class="ltext-106 cl5 txt-center">
                    Related Products
                </h3>
            </div>
            {{-- {{dd($relatedProducts)}} --}}
            <!-- Slide2 -->
            <div class="wrap-slick2">
                <div class="slick2">
                    @forelse ($relatedProducts as $product)
                        @include('livewire.customer.includes.product-card', ['class' => 'item-slick2 p-l-15 p-r-15 p-t-15 p-b-15'])
                    @empty
                        <h5 class="flex-c-m cl5 size-103">no related products found</h5>
                    @endforelse

                </div>
            </div>
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

                /*==================================================================
        [ Slick2 ]*/
                $('.wrap-slick2').each(function () {
                    $(this).find('.slick2').slick({
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        infinite: false,
                        autoplay: false,
                        autoplaySpeed: 6000,
                        arrows: true,
                        appendArrows: $(this),
                        prevArrow: '<button class="arrow-slick2 prev-slick2"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
                        nextArrow: '<button class="arrow-slick2 next-slick2"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
                        responsive: [
                            {
                                breakpoint: 1200,
                                settings: {
                                    slidesToShow: 4,
                                    slidesToScroll: 4
                                }
                            },
                            {
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 3
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 2
                                }
                            },
                            {
                                breakpoint: 576,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });
                });

                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var nameTab = $(e.target).attr('href');
                    $(nameTab).find('.slick2').slick('reinit');
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