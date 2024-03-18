@php
    $current_url = request()->path();
@endphp


<nav>
    <div class="container">
        <div class="container__links">
            @if(!\App\Models\User::isManager())
                <a href="{{url('/paslaugos')}}" class="container__link" data-current="{{str_contains($current_url, 'paslaugos') ? 'true' : 'false'}}">
                    <div class="container__link__flex">
                        <div class="container__link__left style-fs-16">
                            Paslaugos
                        </div>
                    </div>
                </a>
            @endif
            @if(\App\Models\User::isManager() || \App\Models\User::isAdmin())
                <a href="{{url('/bendrijos')}}" class="container__link" data-current="{{str_contains($current_url, 'bendrijos') ? 'true' : 'false'}}">
                    <div class="container__link__flex">
                        <div class="container__link__left style-fs-16">
                            Bendrijos
                        </div>
                    </div>
                </a>
            @endif
            @if(\App\Models\User::isAdmin())
                <a href="{{url('/namai')}}" class="container__link" data-current="{{str_contains($current_url, 'namai') ? 'true' : 'false'}}">
                    <div class="container__link__flex">
                        <div class="container__link__left style-fs-16">
                            Namai
                        </div>
                    </div>
                </a>
                <a href="{{url('/vartotojai')}}" class="container__link" data-current="{{str_contains($current_url, 'vartotojai') ? 'true' : 'false'}}">
                    <div class="container__link__flex">
                        <div class="container__link__left style-fs-16">
                            Vartotojai
                        </div>
                    </div>
                </a>
            @endif

            <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" class="container__link container-log-out">
                <div class="container__link__flex">
                    <div class="container__link__left style-fs-16">
                        Atsijungti
                    </div>
                </div>
            </a>
        </div>
    </div>
</nav>
