<x-layout>
    <x-nav />
    <div class="nav-margin">
        <x-current title="Vartotojai" icon="images/page-users.svg">
            <button type="button" class="style-fs-14 default-green-button component__current__right__button load-new-creation-form">
                <img src="{{asset('images/smaller-plus.svg')}}" />
                Naujas vartotojas
            </button>
        </x-current>
        <section class="section-users">
            @if(session('status'))
                <div class="component-success-notification">
                    <img src="{{asset('images/CheckCircle.svg')}}" />
                    <div class="style-fs-14 text">
                        {{session('status')}}
                    </div>
                </div>
            @endif
                <div class="blocks">
                    <table id="table_id" class="component__table">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $houses = \App\Models\House::all();
                            $failedValidationUserId = (int)\Illuminate\Support\Facades\Session::get('user_id');
                            $roles = \App\Models\Role::all();

                        @endphp

                        @foreach($users as $user_d)
                            <tr>
                                <td>
                                    <div class="hover__green-cl component__table__data style-fs-16">{{$user_d->login}}</div>
                                </td>
                                <td>
                                    <div class="component__table__data style-fs-16">
                                        <img src="{{asset('images/smalluser.svg')}}" />
                                        {{$user_d->role->name}}
                                    </div>
                                </td>
                                <td>
                                    <div class="component__table__data style-fs-16">
                                        <a href="tel:{{$user_d->phone}}" class="component__table__data--href">
                                            <img src="{{asset('images/phone.svg')}}" />
                                            {{$user_d->phone}}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="hover__green-cl component__table__data style-fs-16">{{$user_d->name . ' ' . $user_d->last_name}}</div>
                                </td>
                                <td class="last">
                                    <button type="button" class="default-actions-button">
                                        <img src="{{asset('images/actions.svg')}}" />
                                    </button>
                                    <div class="default-actions">
                                        <div class="triangle"></div>
                                        <a href="#" class="action style-fs-14 hover__green-cl show-edit-popup">Vartotojo informacija</a>
                                        <form class="delete-user-form" method="POST" action="{{url("/istrinti-vartotoja/$user_d->id")}}" style="display: none">
                                            @csrf
                                        </form>
                                        <a href="{{route('users.delete', $user_d->id)}}" class="action style-fs-14 red hover__darkred-cl delete-user-button-form-link">Ištrinti vartotoją</a>
                                    </div>
                                    <div class="default-popup edit-popup  {{ $errors->hasBag('editUserForm') && $user_d->id === $failedValidationUserId ? 'active' : '' }}" id="new-user-popup">
                                        <form class="default-popup__container user-registration" id="user-registration-form" method="POST" action="{{route('users.edit', $user_d->id)}}">
                                            @csrf
                                            <div class="relative-loader">
                                                <div class="loader"></div>
                                            </div>
                                            <button type="button" class="default-popup__close hover__green-childimg">
                                                <img src="{{asset('images/close.svg')}}" />
                                            </button>
                                            <div class="default-popup__heading">
                                                <img src="{{asset('images/user-icon.svg')}}" />
                                                <h2 class="style-fs-28">{{$user_d->name . ' ' . $user_d->last_name}}</h2>
                                            </div>
                                            <div class="user-registration__grid">
                                                <div class="user-registration__block">
                                                    <label for="new-user_role-select" class="user-registration__label style-fs-16">Vartotojo rolė*</label>
                                                    <select  name="role_id" data-required class="add-select2--placeholder" data-width="100%">
                                                        @foreach($roles as $role)
                                                            <option {{$user_d->role->id == $role->id  ? 'selected' : ''}} value="{{$role->id}}">{{$role->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('role_id', 'editUserForm')
                                                    <div class="default-error active style-fs-14">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="user-registration__block">
                                                    <label for="new-user_name" class="user-registration__label style-fs-16">Vardas*</label>
                                                    <input type="text" name="name" id="new-user_name" data-required value="{{$user_d->name}}" class="default-input style-fs-16">
                                                    @error('name', 'editUserForm')
                                                    <div class="default-error active style-fs-14">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="user-registration__block">
                                                    <label for="new-user_lname" class="user-registration__label style-fs-16">Pavardė*</label>
                                                    <input type="text" name="last_name" id="new-user_lname" data-required value="{{$user_d->last_name}}" class="default-input style-fs-16">
                                                    @error('last_name', 'editUserForm')
                                                    <div class="default-error active style-fs-14">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="user-registration__block">
                                                    <label for="new-user_phone" class="user-registration__label style-fs-16">Telefono numeris*</label>
                                                    <input type="tel" name="phone" id="new-user_phone" data-required value="{{$user_d->phone}}" class="default-input style-fs-16">
                                                    @error('phone', 'editUserForm')
                                                    <div class="default-error active style-fs-14">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="user-registration__block">
                                                    <label for="new-user_house-select" class="user-registration__label style-fs-16">Namas</label>
                                                    <select  name="house_id" data-required  data-width="100%">
                                                        <option value="">Nepriskirtas</option>
                                                        @foreach($houses as $house)
                                                            <option {{$user_d->house_id == $house->id  ? 'selected' : ''}} value="{{$house->id}}">{{$house->address}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('house_id', 'editUserForm')
                                                    <div class="default-error active style-fs-14">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <button type="submit" class="default-green-button default-popup__submit style-fs-16">
                                                Sukurti naują vartotoją
                                                <img src="{{asset('images/arrow-bold.svg')}}" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </section>
    </div>

    <div class="default-popup new-creation-popup {{ $errors->hasBag('newUserForm') ? 'active' : '' }}" id="new-user-popup">
        <form class="default-popup__container user-registration" id="user-registration-form" method="POST" action="{{route('users.create')}}">
            @csrf
            <div class="relative-loader">
                <div class="loader"></div>
            </div>
            <button type="button" class="default-popup__close hover__green-childimg">
                <img src="{{asset('images/close.svg')}}" />
            </button>
            <div class="default-popup__heading">
                <img src="{{asset('images/user-icon.svg')}}" />
                <h2 class="style-fs-28">Vartotojo registracija</h2>
            </div>
            <div class="user-registration__grid">
                <div class="user-registration__block">
                    <label for="new-user_role-select" class="user-registration__label style-fs-16">Vartotojo rolė*</label>
                    <select id="new-user_role-select" name="role_id" data-required class="add-select2--placeholder" data-width="100%">
                        @foreach($roles as $role)
                            <option {{old('role') == $role->id  ? 'selected' : ''}} value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                    @error('role_id', 'newUserForm')
                    <div class="default-error active style-fs-14">{{$message}}</div>
                    @enderror
                </div>
                <div class="user-registration__block">
                    <label for="new-user_name" class="user-registration__label style-fs-16">Vardas*</label>
                    <input type="text" name="name" id="new-user_name" data-required value="{{old('name')}}" class="default-input style-fs-16">
                    @error('name', 'newUserForm')
                    <div class="default-error active style-fs-14">{{$message}}</div>
                    @enderror
                </div>
                <div class="user-registration__block">
                    <label for="new-user_lname" class="user-registration__label style-fs-16">Pavardė*</label>
                    <input type="text" name="last_name" id="new-user_lname" data-required value="{{old('last_name')}}" class="default-input style-fs-16">
                    @error('last_name', 'newUserForm')
                    <div class="default-error active style-fs-14">{{$message}}</div>
                    @enderror
                </div>
                <div class="user-registration__block">
                    <label for="new-user_phone" class="user-registration__label style-fs-16">Telefono numeris*</label>
                    <input type="tel" name="phone" id="new-user_phone" data-required value="{{old('phone')}}" class="default-input style-fs-16">
                    @error('phone', 'newUserForm')
                    <div class="default-error active style-fs-14">{{$message}}</div>
                    @enderror
                </div>
                <div class="user-registration__block">
                    <label for="new-user_house-select" class="user-registration__label style-fs-16">Namas</label>
                    <select id="new-user_house-select" name="house_id" data-required  data-width="100%">
                        <option value="">Nepriskirtas</option>
                        @foreach($houses as $house)
                            <option {{old('house_id') == $house->id  ? 'selected' : ''}} value="{{$house->id}}">{{$house->address}}</option>
                        @endforeach
                    </select>
                    @error('house_id', 'newUserForm')
                    <div class="default-error active style-fs-14">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="default-green-button default-popup__submit style-fs-16">
                Sukurti naują vartotoją
                <img src="{{asset('images/arrow-bold.svg')}}" />
            </button>
        </form>
    </div>

</x-layout>
