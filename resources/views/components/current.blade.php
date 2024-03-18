<div class="component__current">
    <div class="component__current__left">
        @if(isset($icon))
            <img src="{{asset($icon)}}" class="component__current__left__icon" />
        @endif
        <h1 class="style-fs-20 component__current__left__heading">{{$title}}</h1>
    </div>
    <div class="component__current__right">
        {{$slot}}
    </div>
</div>
