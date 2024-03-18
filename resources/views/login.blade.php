<x-layout class="page-login page-real-login">
    <div class="login-wrapper wrapper">
        <form class="container" id="login-form" method="POST" action="{{route('login.submit')}}">
            @csrf
            <h1 class="style-fs-28 container__heading">Prisijunkite prie savo paskyros</h1>
            @error('invalid')
            <div class="component-notification red start">
                <img src="{{asset('images/WarningCircle.svg')}}" />
                <div class="style-fs-14 text">
                    {{$message}}
                </div>
            </div>
            @enderror
            <div class="container__block">
                <label for="login" class="style-fs-16 container__label">Prisijungimo vardas</label>
                <input type="text" name="login" id="login" data-required value="{{old('login')}}" class="default-input container__input style-fs-16" />
                @error('login')
                <div class="default-error style-fs-14 active">{{$message}}</div>
                @enderror
            </div>
            <div class="container__block margin">
                <label for="password" class="style-fs-16 container__label">Slaptažodis</label>
                <input type="password" name="password" id="password" data-required class="default-input container__input style-fs-16" />
                @error('password')
                <div class="default-error active style-fs-14">{{$message}}</div>
                @enderror
            </div>
            <button type="submit" class="container__button style-fs-16 default-green-button">
                Prisijungti
            </button>
        </form>
    </div>
</x-layout>
