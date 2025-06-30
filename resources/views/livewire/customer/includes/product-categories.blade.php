@forelse ($categories as $cat)
    <button wire:click="setCategory('{{$cat->name}}')" @class([
        'stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1' => $category === $cat->name,
        'stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5' => $category !== $cat->name,
    ]) data-filter=".{{$cat->name}}">
        {{$cat->name}}
    </button>
@empty
@endforelse