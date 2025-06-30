<footer class="bg3 p-t-75 p-b-32">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Categories
                </h4>

                <ul>
                    @forelse($categories as $category)
                        <li class="p-b-10">
                            <a href="{{ route('products')}}?category={{ $category->name}}"
                                class="stext-107 cl7 hov-cl1 trans-04">
                                {{ $category->name}}
                            </a>
                        </li>
                    @empty
                        <li class="p-b-10">
                            No categories
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                See all products
                            </a>
                        </li>
                    @endforelse

                </ul>
            </div>

            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Help
                </h4>

                <ul>
                    @auth
                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Track Orders
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Returns
                            </a>
                        </li>


                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Shipping
                            </a>
                        </li>
                    @endauth

                    <li class="p-b-10">
                        <a href="{{route('contact')}}" class="stext-107 cl7 hov-cl1 trans-04">
                            Contact Us
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    GET IN TOUCH
                </h4>

                <p class="stext-107 cl7 size-201">
                    Any questions? Let us know in store at {{$contact->address}} or call us
                    on {{$contact->phone}}
                </p>

                <div class="p-t-27">
                    <a href="https://www.facebook.com/ilvarire" target="_blank"
                        class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                        <i class="fa fa-facebook"></i>
                    </a>

                    <a href="https://www.instagram.com/ilvarire" target="_blank"
                        class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                        <i class="fa fa-instagram"></i>
                    </a>

                    <a href="https://wa.me/message/5NQ3PHJOHZVCP1" target="_blank"
                        class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Newsletter
                </h4>

                <form wire:submit.prevent="subscribe" method="post">
                    <div class="wrap-input1 w-full p-b-4">
                        <input class="input1 bg-none plh1 stext-107 cl7" type="email" wire:model="email"
                            placeholder="email@example.com" required>
                        <div class="focus-input1 trans-04"></div>
                        @error ('email')
                            <h3 class="stext-111 cl6 p-t-2" style="color: maroon">{{$message}}</h3>
                        @enderror
                    </div>

                    <div class="p-t-18">
                        <button type="submit"
                            class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                            Subscribe
                        </button>
                        @if (session('status') === 'subscribed')
                            <p x-data="{ show: true }" x-show="show" x-transition
                                x-init="setTimeout(() => show = false, 2000)" class="m-t-4" style="color: seagreen;">
                                {{ __('Thank you.') }}
                            </p>
                        @endif
                    </div>

                </form>
            </div>
        </div>

        <div class="p-t-40">
            <div class="flex-c-m flex-w p-b-18">

                <a href="/" class="m-all-1">
                    <img src="{{ asset('images/icons/icon-pay-02.png')}}" alt="ICON-PAY">
                </a>

                <a href="/" class="m-all-1">
                    <img src="{{ asset('images/icons/icon-pay-03.png')}}" alt="ICON-PAY">
                </a>

                <a href="/" class="m-all-1">
                    <img src="{{ asset('images/icons/icon-pay-04.png')}}" alt="ICON-PAY">
                </a>

                <a href="/" class="m-all-1">
                    <img src="{{ asset('images/icons/icon-pay-05.png')}}" alt="ICON-PAY">
                </a>
            </div>

            <p class="stext-107 cl6 txt-center">
                Copyright &copy;
                <script>document.write(new Date().getFullYear());</script> All rights reserved | Developed by <a
                    href="https://wa.me/message/5NQ3PHJOHZVCP1" target="_blank">Ilvarire
                    Technologies</a>

            </p>
        </div>
    </div>
</footer>