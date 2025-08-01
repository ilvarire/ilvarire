@forelse ($heroDatas as $heroData)
    <div class="item-slick1" style="background-image: url({{ asset('storage/' . $heroData->image_path) }});">
        <div class="container h-full">
            <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                    <span class="ltext-101 cl2 respon2" style="color: {{$heroData->text_color}}">
                        {{$heroData->heading}}
                    </span>
                </div>

                <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                    <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1" style="color: {{$heroData->text_color}}">
                        {{$heroData->main_text}}
                    </h2>
                </div>

                <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                    <a href="{{$heroData->link}}"
                        class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>
    </div>
@empty
@endforelse