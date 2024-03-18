<x-layout>
    <x-nav />
    <div class="nav-margin">
        <x-current title="Namai" icon="images/sandelis.svg">
            <button type="button" class="style-fs-14 default-green-button component__current__right__button load-new-creation-form">
                <img src="{{asset('images/smaller-plus.svg')}}" />
                Naujas namas
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
                        $houses = \App\Models\House::with('community')->get();
                        $communities = \App\Models\Community::all();
                        $failedValidationHouseId = (int)\Illuminate\Support\Facades\Session::get('house_id');
                    @endphp
                    @foreach($houses as $house)
                        <tr>
                            <td>
                                <div class="hover__green-cl component__table__data style-fs-16">{{$house->address}}</div>
                            </td>
                            <td>
                                <div class="hover__green-cl component__table__data style-fs-16">{{$house->community ? $house->community->name : 'Bendrija nepriskirta'}}</div>
                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td class="last">
                                <button type="button" class="default-actions-button">
                                    <img src="{{asset('images/actions.svg')}}" />
                                </button>
                                <div class="default-actions">
                                    <div class="triangle"></div>
                                    <a href="#" class="action style-fs-14 hover__green-cl show-edit-popup">Namo informacija</a>
                                    <form class="delete-user-form" method="POST" action="{{route('houses.delete', $house->id)}}" style="display: none">
                                        @csrf
                                    </form>
                                    <a href="#" class="action style-fs-14 red hover__darkred-cl delete-user-button-form-link">Ištrinti namą</a>
                                </div>
                                <div class="default-popup edit-popup {{ $errors->hasBag('editHouseForm') && $house->id === $failedValidationHouseId ? 'active' : '' }}" id="edit-house-popup" >
                                    <form class="default-popup__container user-registration" id="new-house-form" method="POST" action="{{route('houses.edit', $house->id)}}" >
                                        @csrf
                                        <div class="relative-loader">
                                            <div class="loader"></div>
                                        </div>
                                        <button type="button" class="default-popup__close hover__green-childimg">
                                            <img src="{{asset('images/close.svg')}}" />
                                        </button>
                                        <div class="default-popup__heading">
                                            <img src="{{asset('images/sandelis.svg')}}" />
                                            <h2 class="style-fs-28">{{$house->address}}</h2>
                                        </div>
                                        <div class="user-registration__grid">
                                            <div class="user-registration__block">
                                                <label for="new-house__address" class="user-registration__label style-fs-16">Adresas*</label>
                                                <input type="text" name="address" id="new-house__address" data-required value="{{$house->address}}" class="default-input style-fs-16">
                                                @error('address', 'editHouseForm')
                                                <div class="default-error active style-fs-14">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <div class="user-registration__block">
                                                <label for="new-house__community" class="user-registration__label style-fs-16">Bendrija</label>
                                                <select  name="community_id" data-required  data-width="100%">
                                                    <option value="">Nepriskirta</option>

                                                    @foreach($communities as $community)
                                                        <option {{$house->community && $house->community->id == $community->id  ? 'selected' : ''}} value="{{$community->id}}">{{$community->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('community_id', 'editHouseForm')
                                                <div class="default-error active style-fs-14">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="default-green-button default-popup__submit style-fs-16">
                                            Redaguoti namą
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
    <div class="default-popup new-creation-popup {{ $errors->hasBag('newHouseForm') ? 'active' : '' }}" id="new-house-popup" >
        <form class="default-popup__container user-registration" id="new-house-form" method="POST" action="{{route('houses.create')}}" >
            @csrf
            <div class="relative-loader">
                <div class="loader"></div>
            </div>
            <button type="button" class="default-popup__close hover__green-childimg">
                <img src="{{asset('images/close.svg')}}" />
            </button>
            <div class="default-popup__heading">
                <img src="{{asset('images/sandelis.svg')}}" />
                <h2 class="style-fs-28">Namo sukūrimas</h2>
            </div>
            <div class="user-registration__grid">
                <div class="user-registration__block">
                    <label for="new-house__address" class="user-registration__label style-fs-16">Adresas*</label>
                    <input type="text" name="address" id="new-house__address" data-required value="{{old('address')}}" class="default-input style-fs-16">
                    @error('address', 'newHouseForm')
                    <div class="default-error active style-fs-14">{{$message}}</div>
                    @enderror
                </div>
                <div class="user-registration__block">
                    <label for="new-house__community" class="user-registration__label style-fs-16">Bendrija</label>
                    <select id="new-house__community" name="community_id" data-required class="add-select2--placeholder" data-width="100%">
                        <option></option>
                        @foreach($communities as $community)
                            <option {{old('community_id') == $community->id  ? 'selected' : ''}} value="{{$community->id}}">{{$community->name}}</option>
                        @endforeach
                    </select>
                    @error('community_id', 'newHouseForm')
                    <div class="default-error active style-fs-14">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="default-green-button default-popup__submit style-fs-16">
                Sukurti naują namą
                <img src="{{asset('images/arrow-bold.svg')}}" />
            </button>
        </form>
    </div>

</x-layout>
