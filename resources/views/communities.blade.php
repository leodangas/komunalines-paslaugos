<x-layout>
    <x-nav />
    <div class="nav-margin">
        <x-current title="Bendrijos" icon="images/sandelis.svg">
            @if(\App\Models\User::isAdmin())
                <button type="button" class="style-fs-14 default-green-button component__current__right__button load-new-creation-form">
                    <img src="{{asset('images/smaller-plus.svg')}}" />
                    Nauja bendrija
                </button>
            @endif
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
                        $communities = isset($communities) ? $communities : \App\Models\Community::with('services')->get();
                        $failedValidationCommunityId = (int)\Illuminate\Support\Facades\Session::get('community_id');
                        $services = \App\Models\Service::all();
                    @endphp
                    @foreach($communities as $community)
                        <tr>
                            <td>
                                <div class="hover__green-cl component__table__data style-fs-16">{{$community->name}}</div>
                            </td>
                            <td>
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
                                    @if(\App\Models\User::isAdmin())
                                        <a href="#" class="action style-fs-14 hover__green-cl show-edit-popup">Bendrijos informacija</a>
                                        <a href="{{route('communities.houses', $community->id)}}" class="action style-fs-14 hover__green-cl">Bendrijos namai</a>
                                        <a href="{{route('communities.services', $community->id)}}" class="action style-fs-14 hover__green-cl">Bendrijos paslaugos</a>
                                        <form class="delete-user-form" method="POST" action="{{route('communities.delete', $community->id)}}" style="display: none">
                                            @csrf
                                        </form>
                                        <a href="#" class="action style-fs-14 red hover__darkred-cl delete-user-button-form-link">Ištrinti bendriją</a>
                                    @else
                                        <a href="{{route('communities.services', $community->id)}}" class="action style-fs-14 hover__green-cl">Bendrijos paslaugos</a>
                                    @endif
                                </div>
                                @if(\App\Models\User::isAdmin())
                                <div class="default-popup edit-popup {{ $errors->hasBag('editCommunityForm') && $community->id === $failedValidationCommunityId ? 'active' : '' }}" id="edit-community-popup" >
                                    <form class="default-popup__container user-registration" id="new-community-form" method="POST" action="{{route('communities.edit', $community->id)}}" >
                                        @csrf
                                        <div class="relative-loader">
                                            <div class="loader"></div>
                                        </div>
                                        <button type="button" class="default-popup__close hover__green-childimg">
                                            <img src="{{asset('images/close.svg')}}" />
                                        </button>
                                        <div class="default-popup__heading">
                                            <img src="{{asset('images/sandelis.svg')}}" />
                                            <h2 class="style-fs-28">{{$community->name}}</h2>
                                        </div>
                                        <div class="user-registration__grid">
                                            <div class="user-registration__block">
                                                <label for="new-house__address" class="user-registration__label style-fs-16">Pavadinimas*</label>
                                                <input type="text" name="name" id="new-house__address" data-required value="{{$community->name}}" class="default-input style-fs-16">
                                                @error('address', 'editCommunityForm')
                                                <div class="default-error active style-fs-14">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <div class="user-registration__block">
                                                <label for="new-house__community" class="user-registration__label style-fs-16">Tiekiamos paslaugos</label>
                                                <select name="services[]" data-required  class="add-select2--placeholder" data-width="100%" multiple="multiple">
                                                    <option></option>
                                                    @foreach($services as $service)
                                                        <option {{$community->services->contains($service->id) ? 'selected' : ''}} value="{{$service->id}}">{{$service->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('community_id', 'newCommunityForm')
                                                <div class="default-error active style-fs-14">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="default-green-button default-popup__submit style-fs-16">
                                            Redaguoti bendriją
                                            <img src="{{asset('images/arrow-bold.svg')}}" />
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    @if(\App\Models\User::isAdmin())
    <div class="default-popup new-creation-popup {{ $errors->hasBag('newCommunityForm') ? 'active' : '' }}" id="new-community-popup" >
        <form class="default-popup__container user-registration" id="new-community-form" method="POST" action="{{route('communities.create')}}" >
            @csrf
            <div class="relative-loader">
                <div class="loader"></div>
            </div>
            <button type="button" class="default-popup__close hover__green-childimg">
                <img src="{{asset('images/close.svg')}}" />
            </button>
            <div class="default-popup__heading">
                <img src="{{asset('images/sandelis.svg')}}" />
                <h2 class="style-fs-28">Bendrijos sukūrimas</h2>
            </div>
            <div class="user-registration__grid">
                <div class="user-registration__block">
                    <label for="new-community__name" class="user-registration__label style-fs-16">Pavadinimas*</label>
                    <input type="text" name="name" id="new-community__name" data-required value="{{old('name')}}" class="default-input style-fs-16">
                    @error('name', 'newCommunityForm')
                    <div class="default-error active style-fs-14">{{$message}}</div>
                    @enderror
                </div>
                <div class="user-registration__block">
                    <label for="new-house__community" class="user-registration__label style-fs-16">Tiekiamos paslaugos</label>
                    <select name="services[]" data-required  class="add-select2--placeholder" data-width="100%" multiple="multiple">
                        <option></option>
                        @foreach($services as $service)
                            <option {{is_array(old('services')) && in_array($service->id, old('services')) ? 'selected' : ''}} value="{{$service->id}}">{{$service->name}}</option>
                        @endforeach
                    </select>
                    @error('community_id', 'newCommunityForm')
                    <div class="default-error active style-fs-14">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="default-green-button default-popup__submit style-fs-16">
                Sukurti naują bendriją
                <img src="{{asset('images/arrow-bold.svg')}}" />
            </button>
        </form>
    </div>
    @endif

</x-layout>
