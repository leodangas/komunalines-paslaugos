<x-layout>
    <x-nav />
    <div class="nav-margin">
        <x-current title="Paslaugos" icon="images/cube-small.svg">
            <button type="button" class="style-fs-14 default-green-button component__current__right__button load-new-creation-form">
                <img src="{{asset('images/smaller-plus.svg')}}" />
                Nauja paslauga
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
                        $services = \App\Models\Service::all();
                        $failedValidationServiceId = (int)\Illuminate\Support\Facades\Session::get('service_id');
                        $managers = \App\Models\User::where('role_id', \App\Models\Role::MANAGER_ID)->get();
                    @endphp
                    @foreach($services as $service)
                        <tr>
                            <td>
                                <div class="hover__green-cl component__table__data style-fs-16">{{$service->name}}</div>
                            </td>
                            <td>
                                <div class="hover__green-cl component__table__data style-fs-16">{{$service->manager ? $service->manager->name . ' ' . $service->manager->last_name : 'Vadybininkas nepriskirtas'}}</div>
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
                                    <a href="#" class="action style-fs-14 hover__green-cl show-edit-popup">Paslaugos informacija</a>
                                </div>
                                    <div class="default-popup edit-popup {{ $errors->hasBag('editServiceForm') && $service->id === $failedValidationServiceId ? 'active' : '' }}" id="edit-house-popup" >
                                        <form class="default-popup__container user-registration" id="new-house-form" method="POST" action="{{route('services.edit', $service->id)}}" >
                                            @csrf
                                            <div class="relative-loader">
                                                <div class="loader">
                                                </div>
                                                <button type="button" class="default-popup__close hover__green-childimg">
                                                    <img src="{{asset('images/close.svg')}}" />
                                                </button>
                                                <div class="default-popup__heading">
                                                    <img src="{{asset('images/sandelis.svg')}}" />
                                                    <h2 class="style-fs-28">{{$service->name}}</h2>
                                                </div>
                                                <div class="user-registration__grid">
                                                    <div class="user-registration__block">
                                                        <label for="new-house__address" class="user-registration__label style-fs-16">Pavadinimas*</label>
                                                        <input type="text" name="name" id="new-house__address" data-required value="{{$service->name}}" class="default-input style-fs-16">
                                                        @error('name', 'editServiceForm')
                                                        <div class="default-error active style-fs-14">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="user-registration__block">
                                                        <label for="new-user_role-select" class="user-registration__label style-fs-16">Vadybininkas*</label>
                                                        <select  name="manager_id" data-required  data-width="100%">
                                                            <option value="">Nepriskirtas</option>
                                                            @foreach($managers as $manager)
                                                                <option {{$service->manager && $service->manager->id == $manager->id  ? 'selected' : ''}} value="{{$manager->id}}">{{$manager->name . ' ' . $manager->last_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('manager_id', 'editServiceForm')
                                                        <div class="default-error active style-fs-14">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <button type="submit" class="default-green-button default-popup__submit style-fs-16">
                                                    Redaguoti paslaugą
                                                    <img src="{{asset('images/arrow-bold.svg')}}" />
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

    <div class="default-popup new-creation-popup {{ $errors->hasBag('createServiceForm') ? 'active' : '' }}" id="create-house-popup" >
        <form class="default-popup__container user-registration" id="new-house-form" method="POST" action="{{route('services.create', $service->id)}}" >
            @csrf
            <div class="relative-loader">
                <div class="loader">
                </div>
                <button type="button" class="default-popup__close hover__green-childimg">
                    <img src="{{asset('images/close.svg')}}" />
                </button>
                <div class="default-popup__heading">
                    <img src="{{asset('images/sandelis.svg')}}" />
                    <h2 class="style-fs-28">{{'Naujos paslaugos kurimas'}}</h2>
                </div>
                <div class="user-registration__grid">
                    <div class="user-registration__block">
                        <label for="new-house__address" class="user-registration__label style-fs-16">Pavadinimas*</label>
                        <input type="text" name="name" id="new-house__address" data-required value="{{old('name')}}" class="default-input style-fs-16">
                        @error('name', 'createServiceForm')
                        <div class="default-error active style-fs-14">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="user-registration__block">
                        <label for="new-user_role-select" class="user-registration__label style-fs-16">Vadybininkas*</label>
                        <select  name="manager_id" data-required  data-width="100%">
                            <option value="">Nepriskirtas</option>
                            @foreach($managers as $manager)
                                <option {{old('manager_id') == $manager->id  ? 'selected' : ''}} value="{{$manager->id}}">{{$manager->name . ' ' . $manager->last_name}}</option>
                            @endforeach
                        </select>
                        @error('manager_id', 'newServiceForm')
                        <div class="default-error active style-fs-14">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="default-green-button default-popup__submit style-fs-16">
                    Kurti paslaugą
                    <img src="{{asset('images/arrow-bold.svg')}}" />
                </button>
            </div>
        </form>
    </div>

    </section>
    </div>


</x-layout>
