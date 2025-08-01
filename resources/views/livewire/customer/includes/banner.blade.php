@forelse($bannerDatas as $bannerData)
    <div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
        <!-- Block1 -->
        <div class="block1 wrap-pic-w">
            <img src="{{ asset('storage/' . $bannerData->image_path) }}" alt="IMG-BANNER">

            <a href="{{ $bannerData->link }}"
                class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                <div class="block1-txt-child1 flex-col-l">
                    <span class="block1-name ltext-102 trans-04 p-b-8">
                        {{ $bannerData->main_text }}
                    </span>

                    <span class="block1-info stext-102 trans-04">
                        {{ $bannerData->sub_text }}
                    </span>
                </div>

                <div class="block1-txt-child2 p-b-4 trans-05">
                    <div class="block1-link stext-101 cl0 trans-09">
                        Shop Now
                    </div>
                </div>
            </a>
        </div>
    </div>
@empty
@endforelse