<div class="s-top-menu">
    <div class="app-name">
        <a title="{{__('Naslovna strana')}}">
            <img src="{{ asset('files/images/logo.svg') }}" alt="">
        </a>
        <i class="fas fa-bars t-3 system-m-i-t" title="{{__('Otvorite / zatvorite MENU')}}"></i>
    </div>

    <div class="top-menu-links">
        <!-- Left top icons -->
        <div class="left-icons">
            <div class="single-li">
                <a href="#" target="_blank" title="{{ __('Aktivnih obuka') }}">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <div class="number-of"><p>5</p></div>
                </a>
            </div>

            @if(Auth()->user()->role == 'admin')
                <a href="#" target="_blank">
                    <div class="single-li">
                        <p> {{__('Programi')}} </p>
                    </div>
                </a>
                <a href="#">
                    <div class="single-li">
                        <p> {{__('Korisnici')}} </p>
                    </div>
                </a>
            @elseif(Auth()->user()->role == 'user')

            @endif
        </div>

        <!-- Right top icons -->
        <div class="right-icons">
            <div class="single-li main-search-w" title="">
                <i class="fas fa-search main-search-t hover-white" title="{{__('Pretražite')}}"></i>
{{--                @include('system.template.menu.menu-includes.search')--}}
            </div>
            <div class="single-li m-show-notifications" title="Pregled obavijesti">
                <i class="fas fa-bell m-show-notifications-icon hover-white"></i>
                <div class="number-of number-of-not @if(!Auth()->user()->notifications) d-none @endif"><p id="no-unread-notifications">{{ Auth()->user()->notifications ?? '' }}</p></div>

                @include('admin.layout.snippets.includes.notifications')
            </div>
            <a href="#">
                <div class="single-li single-li-text user-name">
                    <p><b> {{ Auth()->user()->name }} </b></p>
{{--                    {!! Form::hidden('user_id', json_encode($loggedUser), ['class' => 'form-control', 'id' => 'loggedUser']) !!}--}}
                </div>
            </a>
            <div class="single-li main-search-w" title="">
                <a href="{{ route('auth.logout') }}">
                    <i class="fas fa-power-off hover-white" title="{{__('Odjavite se')}}"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!--------------------------------------------------------------------------------------------------------------------->

<div class="s-left-menu t-3">
    <!-- user Info -->
    <div class="user-info">
        <div class="user-image">
            <img src="{{ asset('files/images/default/sparrow.webp') }}" alt="">
{{--            <img class="mp-profile-image" title="{{__('Promijenite sliku profila')}}" src="{{ isset($loggedUser->profileImgRel) ? asset( $loggedUser->profileImgRel->getFile()) : asset('images/user.png')}}" alt="">--}}
        </div>
        <div class="user-desc">
            <h4> {{ Auth()->user()->name }} </h4>
            <p> {{ Auth()->user()->getRole() }} </p>
            <p>
                <i class="fas fa-circle"></i>
                Online
            </p>
        </div>
    </div>
    <hr>

    <!-- Menu subsection -->
    <div class="s-lm-subsection">

        <div class="subtitle">
            <h4>{{__('Grafičko sučelje')}}</h4>
            <div class="subtitle-icon">
                <i class="fas fa-chart-area"></i>
            </div>
        </div>
        @if(Auth()->user()->role == 'admin' or Auth()->user()->role == 'moderator')
            <a href="{{ route('system.home') }}" class="menu-a-link">
                <div class="s-lm-wrapper @if(Route::is('system.home')) active @endif">
                    <div class="s-lm-s-elements">
                        <div class="s-lms-e-img">
                            <i class="fas fa-home"></i>
                        </div>
                        <p>{{__('Dashboard')}}</p>
                        <div class="extra-elements">
                            <div class="ee-t ee-t-b"><p>{{__('Home')}}</p></div>
                        </div>
                    </div>
                </div>
            </a>
        @else
            <a href="{{ route('system.user-data.dashboard') }}" class="menu-a-link">
                <div class="s-lm-wrapper @if(Route::is('system.user-data.dashboard')) active @endif">
                    <div class="s-lm-s-elements">
                        <div class="s-lms-e-img">
                            <i class="fas fa-home"></i>
                        </div>
                        <p>{{__('Dashboard')}}</p>
                        <div class="extra-elements">
                            <div class="ee-t ee-t-b"><p>{{__('Home')}}</p></div>
                        </div>
                    </div>
                </div>
            </a>
        @endif

        <div class="subtitle">
            <h4>{{__('Korisničko sučelje')}}</h4>
            <div class="subtitle-icon">
                <i class="fas fa-project-diagram"></i>
            </div>
        </div>

        <a href="{{ route('system.user-data.my-profile') }}" class="menu-a-link">
            <div class="s-lm-wrapper @if(Route::is('system.user-data.my-profile*')) active @endif">
                <div class="s-lm-s-elements">
                    <div class="s-lms-e-img">
                        <i class="fas fa-user"></i>
                    </div>
                    <p>{{__('Moj profil')}}</p>
                    <div class="extra-elements">
                        <div class="ee-t ee-t-g"><p>{{__('Info')}}</p></div>
                    </div>
                </div>
            </div>
        </a>

        @if(Auth()->user()->role == 'admin' or Auth()->user()->role == 'moderator')
            <a href="#" class="menu-a-link">
                <div class="s-lm-wrapper @if(Route::is('system.admin.trainings*')) active @endif">
                    <div class="s-lm-s-elements">
                        <div class="s-lms-e-img">
                            <img class="normal-icon" src="{{ asset('files/images/icons/training.svg') }}" alt="{{ __('Training image') }}">
                            <img class="yellow-icon" src="{{ asset('files/images/icons/training-yellow.svg') }}" alt="{{ __('Training image') }}">
                        </div>
                        <p>{{__('Sistem obuka')}}</p>
                        <div class="extra-elements">
                            <div class="rotate-element"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                    <div class="inside-links active-links">
                        <a href="{{ route('system.admin.trainings') }}">
                            <div class="inside-lm-link">
                                <div class="ilm-l"></div><div class="ilm-c"></div>
                                <p>{{__('Programi obuka')}}</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="inside-lm-link">
                                <div class="ilm-l"></div><div class="ilm-c"></div>
                                <p> {{__('Instance obuka')}} </p>
                            </div>
                        </a>
                    </div>
                </div>
            </a>
        @else
            <a href="#" class="menu-a-link">
                <div class="s-lm-wrapper @if(Route::is('system.admin.trainings*')) active @endif">
                    <div class="s-lm-s-elements">
                        <div class="s-lms-e-img">
                            <img class="normal-icon" src="{{ asset('files/images/icons/training.svg') }}" alt="{{ __('Training image') }}">
                            <img class="yellow-icon" src="{{ asset('files/images/icons/training-yellow.svg') }}" alt="{{ __('Training image') }}">
                        </div>
                        <p>{{__('Sistem obuka')}}</p>
                        <div class="extra-elements">
                            <div class="rotate-element"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                    <div class="inside-links active-links">
                        <a href="#">
                            <div class="inside-lm-link">
                                <div class="ilm-l"></div><div class="ilm-c"></div>
                                <p>{{__('Sve obuke')}}</p>
                            </div>
                        </a>
                        <a href="#">
                            <div class="inside-lm-link">
                                <div class="ilm-l"></div><div class="ilm-c"></div>
                                <p> {{__('Moje obuke')}} </p>
                            </div>
                        </a>
                    </div>
                </div>
            </a>
        @endif

        @if(Auth()->user()->role == 'admin' or Auth()->user()->role == 'moderator')
            <a href="{{ route('system.admin.users') }}" class="menu-a-link">
                <div class="s-lm-wrapper @if(Route::is('system.admin.users*')) active @endif">
                    <div class="s-lm-s-elements">
                        <div class="s-lms-e-img">
                            <i class="fas fa-users"></i>
                        </div>
                        <p>{{__('Korisnici')}}</p>
                        <div class="extra-elements">
                            <div class="ee-t ee-t-b"><p>{{__('All')}}</p></div>
                        </div>
                    </div>
                </div>
            </a>
        @endif

{{--        <a href="#" class="menu-a-link">--}}
{{--            <div class="s-lm-wrapper">--}}
{{--                <div class="s-lm-s-elements">--}}
{{--                    <div class="s-lms-e-img">--}}
{{--                        <i class="fas fa-wind"></i>--}}
{{--                    </div>--}}
{{--                    <p>{{__('Blog')}}</p>--}}
{{--                    <div class="extra-elements">--}}
{{--                        <div class="ee-t ee-t-b"><p>{{__('Other')}}</p></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </a>--}}

        <div class="subtitle">
            <h4> {{__('Ostalo')}} </h4>
            <div class="subtitle-icon">
                <i class="fas fa-box"></i>
            </div>
        </div>

{{--        <a href="#" class="menu-a-link">--}}
{{--            <div class="s-lm-wrapper">--}}
{{--                <div class="s-lm-s-elements">--}}
{{--                    <div class="s-lms-e-img">--}}
{{--                        <i class="fas fa-file"></i>--}}
{{--                    </div>--}}
{{--                    <p>{{__('Single Pages')}}</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </a>--}}
{{--        <a href="{{ route('system.admin.other.faq') }}" class="menu-a-link">--}}
{{--            <div class="s-lm-wrapper">--}}
{{--                <div class="s-lm-s-elements">--}}
{{--                    <div class="s-lms-e-img">--}}
{{--                        <i class="fas fa-question"></i>--}}
{{--                    </div>--}}
{{--                    <p>{{__('FAQs section')}}</p>--}}
{{--                    <div class="extra-elements">--}}
{{--                        <div class="ee-t ee-t-b"><p>{{__('Other')}}</p></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </a>--}}
{{--        <a href="{{ route('system.admin.core.keywords') }}" class="menu-a-link">--}}
{{--            <div class="s-lm-wrapper">--}}
{{--                <div class="s-lm-s-elements">--}}
{{--                    <div class="s-lms-e-img">--}}
{{--                        <i class="fas fa-key"></i>--}}
{{--                    </div>--}}
{{--                    <p>{{__('Keywords')}}</p>--}}
{{--                    <div class="extra-elements">--}}
{{--                        <div class="ee-t ee-t-b"><p>{{__('Core')}}</p></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </a>--}}

        @if(Auth()->user()->role == 'admin' or Auth()->user()->role == 'moderator')
            <a href="#" class="menu-a-link">
                <div class="s-lm-wrapper @if(Route::is('system.admin.core.*')) active @endif">
                    <div class="s-lm-s-elements">
                        <div class="s-lms-e-img">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <p>{{__('Postavke')}}</p>
                        <div class="extra-elements">
                            <div class="rotate-element"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                    <div class="inside-links active-links">
                        <a href="{{ route('system.admin.core.settings.cities') }}">
                            <div class="inside-lm-link">
                                <div class="ilm-l"></div><div class="ilm-c"></div>
                                <p> {{__('Općine i gradovi')}} </p>
                            </div>
                        </a>
                        <a href="{{ route('system.admin.core.keywords') }}">
                            <div class="inside-lm-link">
                                <div class="ilm-l"></div><div class="ilm-c"></div>
                                <p> {{__('Šifarnici')}} </p>
                            </div>
                        </a>
                    </div>
                </div>
            </a>
        @else
            <a href="#" class="menu-a-link">
                <div class="s-lm-wrapper @if(Route::is('system.admin.core.*')) active @endif">
                    <div class="s-lm-s-elements">
                        <div class="s-lms-e-img">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <p>{{__('Postavke')}}</p>
                        <div class="extra-elements">
                            <div class="rotate-element"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                    <div class="inside-links active-links">
                        <a href="#">
                            <div class="inside-lm-link">
                                <div class="ilm-l"></div><div class="ilm-c"></div>
                                <p> {{__('Notifikacije')}} </p>
                            </div>
                        </a>
                    </div>
                </div>
            </a>
        @endif
    </div>

{{--    @include('system.template.menu.menu-includes.bottom-icons')--}}
</div>


{{--<!-- Upload an image for user account -->--}}
{{--@include('system.template.menu.menu-includes.profile-image')--}}
