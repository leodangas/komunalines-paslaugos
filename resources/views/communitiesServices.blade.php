<x-layout>
    <x-nav />
    <div class="nav-margin">
        <x-current title="{{$community->name . ' paslaugos'}}" icon="images/sandelis.svg">
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
                        $communityServices = isset($services) ? $services : \App\Models\CommunityService::where([
                            'community_id' => $community->id
                        ])->get();

                        $communities = \App\Models\Community::all();
                        $failedValidationCommunityServiceId = (int)\Illuminate\Support\Facades\Session::get('community_service_id');
                    @endphp
                    @if($communityServices->isNotEmpty())
                        @foreach($communityServices as $communityService)
                            @php
                            @endphp
                            <tr>
                                <td>
                                    <div class="hover__green-cl component__table__data style-fs-16">{{$communityService->service->name}}</div>
                                </td>
                                <td>
                                    <div class="hover__green-cl component__table__data style-fs-16">{{$communityService->price ? $communityService->price . '€' : 'Kaina nepriskirta'}}</div>
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td class="last">
                                    @if(!isset($regularUser))
                                    <button type="button" class="default-actions-button">
                                        <img src="{{asset('images/actions.svg')}}" />
                                    </button>
                                    <div class="default-actions">
                                        <div class="triangle"></div>
                                        <a href="#" class="action style-fs-14 hover__green-cl show-edit-popup">Paslaugos informacija</a>
                                    </div>
                                    <div class="default-popup edit-popup {{ $errors->hasBag('editCommunityServiceForm') && $communityService->id === $failedValidationCommunityServiceId ? 'active' : '' }}" id="edit-house-popup" >
                                        <form class="default-popup__container user-registration" id="new-house-form" method="POST" action="{{route('communities.services.edit', $communityService->id)}}" >
                                            @csrf
                                            <div class="relative-loader">
                                                <div class="loader">
                                            </div>
                                            <button type="button" class="default-popup__close hover__green-childimg">
                                                <img src="{{asset('images/close.svg')}}" />
                                            </button>
                                            <div class="default-popup__heading">
                                                <img src="{{asset('images/sandelis.svg')}}" />
                                                <h2 class="style-fs-28">{{$communityService->service->name}}</h2>
                                            </div>
                                            <div class="user-registration__grid">
                                                <div class="user-registration__block">
                                                    <label for="new-house__address" class="user-registration__label style-fs-16">Kaina*</label>
                                                    <input type="text" name="price" id="new-house__address" data-required value="{{$communityService->price}}" class="default-input style-fs-16">
                                                    @error('price', 'editCommunityServiceForm')
                                                    <div class="default-error active style-fs-14">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <button type="submit" class="default-green-button default-popup__submit style-fs-16">
                                                Redaguoti paslaugą
                                                <img src="{{asset('images/arrow-bold.svg')}}" />
                                            </button>
                                        </form>
                                    </div>
                                        @endif
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr class="global-empty">
                            <td >Šiai bendrijai nėra priskirta paslaugų</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-layout>
