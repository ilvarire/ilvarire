<header class="header-v4">
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    Technology and Security at your finger tips
                </div>

                <div class="right-top-bar flex-w h-full">
                    @auth
                        <a href="{{ route('profile') }}" class="flex-c-m trans-04 p-lr-25">
                            My Account
                        </a>

                        <a href="{{ route('orders') }}" class="flex-c-m trans-04 p-lr-25">
                            Orders
                        </a>

                        <form action="{{ route('logout') }}" method="post" id="logout">
                            @csrf

                        </form>
                        <button type="submit" form="logout" class="flex-c-m trans-04 p-lr-25">
                            <div class="left-top-bar">
                                Logout
                            </div>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="flex-c-m trans-04 p-lr-25">
                            Register
                        </a>
                        <a href="{{ route('contact') }}" class="flex-c-m trans-04 p-lr-25">
                            Help
                        </a>
                    @endauth

                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="{{ route('homepage') }}" class="logo">
                    <img src="{{ asset('/images/icons/logo.png')}}" alt="IMG-LOGO" style="width: 150px;">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="{{request()->is('/') ? 'active-menu' : ''}}">
                            <a href="{{ route('homepage') }}">Home</a>

                        </li>

                        <li class="label1 {{request()->is('products') ? 'active-menu' : ''}}" data-label1="hot">
                            <a href="{{ route('products') }}">Shop</a>
                        </li>

                        <li class="{{request()->is('cart') ? 'active-menu' : ''}}">
                            <a href="{{ route('cart') }}">Cart</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                                @auth
                                    <li><a href="{{ route('orders') }}">Orders</a></li>
                                    <li><a href="{{ route('payments') }}">Payments</a></li>
                                @endauth
                            </ul>
                        </li>

                        <li class="{{request()->is('about') ? 'active-menu' : ''}}">
                            <a href="{{ route('about') }}">About</a>
                        </li>

                        <li class="{{request()->is('contact') ? 'active-menu' : ''}}">
                            <a href="{{ route('contact') }}">Contact</a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">

                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                        data-notify="{{ $cartCount }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>

                    <a href="{{ route('wishlist') }}"
                        class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
                        data-notify="{{ $wishlistCount }}">
                        <i class="zmdi zmdi-favorite-outline"></i>
                    </a>
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="{{ route('homepage') }}"><img src="{{ asset('/images/icons/logo.png')}}" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
                data-notify="{{ $cartCount }}">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>

            <a href="{{ route('wishlist') }}"
                class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
                data-notify="{{ $wishlistCount }}">
                <i class="zmdi zmdi-favorite-outline"></i>
            </a>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="topbar-mobile">
            <li>
                <div class="left-top-bar">
                    Technology and Security at your figure tips
                </div>
            </li>

            <li>
                <div class="right-top-bar flex-w h-full">
                    @auth
                        <a href="{{ route('profile') }}" class="flex-c-m p-lr-10 trans-04">
                            My Account
                        </a>

                        <a href="{{ route('orders') }}" class="flex-c-m p-lr-10 trans-04">
                            Orders
                        </a>

                        <form action="{{ route('logout') }}" method="post" id="logout">
                            @csrf

                        </form>

                        <button type="submit" form="logout" class="flex-c-m p-lr-10 trans-04">
                            <div class="left-top-bar">
                                Logout
                            </div>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="flex-c-m p-lr-10 trans-04">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="flex-c-m p-lr-10 trans-04">
                            Register
                        </a>
                        <a href="{{ route('contact') }}" class="flex-c-m p-lr-10 trans-04">
                            Help
                        </a>
                    @endauth

                </div>
            </li>
        </ul>

        <ul class="main-menu-m">
            <li>
                <a href="{{ route('homepage') }}">Home</a>

            </li>

            <li>
                <a href="{{ route('products') }}" class="label1 rs1" data-label1="hot">Shop</a>
            </li>

            <li>
                <a href="{{ route('cart') }}">Cart</a>
                <ul class="sub-menu-m">
                    <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                    @auth
                        <li><a href="{{ route('orders') }}">Orders</a></li>
                        <li><a href="{{ route('payments') }}">Payments</a></li>
                    @endauth

                </ul>
                <span class="arrow-main-menu-m">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>

            <li>
                <a href="{{ route('about') }}">About</a>

            </li>

            <li>
                <a href="{{ route('contact') }}">Contact</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search..." disabled>
            </form>
        </div>
    </div>

    <!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>

        <div class="header-cart flex-col-l p-l-65 p-r-25">
            <div class="header-cart-title flex-w flex-sb-m p-b-8">
                <span class="mtext-103 cl2">
                    Your Cart
                </span>

                <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <div class="header-cart-content flex-w js-pscroll">
                <ul class="header-cart-wrapitem w-full">
                    @if (count($cartItems) > 0)
                        @foreach ($cartItems as $item)
                            @include('livewire.customer.includes.slide-cart')
                        @endforeach
                    @else
                        <span class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                            No products in cart
                        </span>
                    @endif

                </ul>

                <div class="w-full">
                    <div class="header-cart-total w-full p-tb-40">
                        Total: ${{ number_format($subTotal, 2)}}
                    </div>

                    <div class="header-cart-buttons flex-w w-full">
                        <a href="{{route('cart')}}"
                            class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                            View Cart
                        </a>

                        <a href="{{route('cart')}}"
                            class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                            Check Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>