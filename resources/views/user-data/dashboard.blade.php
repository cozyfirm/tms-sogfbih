@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-home"></i> @endsection
@section('c-title') {{ __('Dashboard') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Upravljačka tabla admin panela') }}</p> </a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.user-data.dashboard') }}">
        <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>
    </a>
@endsection

@section('content')
    <div class="homepage">
        <div class="homepage-main">
            <div class="home-row home-row-top">
                <div class="home-row-header">
                    <h4> {{__('OSNOVNE INFORMACIJE')}} </h4>
                </div>

                <div class="home-row-body">
                    <div class="home-row-items">
                        <div class="home-icon" title="{{__('Ukupan broj programa obuka')}}">
                            <h1> {{$trainings ?? '0'}}</h1>
                            <p>{{__('Aktivnih obuka')}}</p>
                        </div>
                        <div class="home-icon" title="{{__('Objavljenih obuka')}}">
                            <h1>{{$instances ?? '0'}}</h1>
                            <p>{{__('Mojih obuka')}}</p>
                        </div>
                        <div class="home-icon" title="{{__('Registrovanih trenera')}}">
                            <h1>{{$trainers ?? '0'}}</h1>
                            <p>{{__('Certifikata')}}</p>
                        </div>
                        <div class="home-icon" title="{{__('Registrovanih korisnika')}}">
                            <h1>{{$users ?? '0'}}</h1>
                            <p>{{__('Sati predavanja')}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="home-row">
                <div class="home-row-header">
                    <h4> {{__('OSTALO')}} </h4>
                </div>

                <div class="home-row-body">
                    <div class="home-row-items">
                        <div class="home-icon go-to" link="{{ route('system.user-data.trainings') }}" title="{{__('Sistem obuka')}}">
                            <img class="normal-icon" src="{{ asset('files/images/icons/training.svg') }}" alt="{{ __('Training image') }}">
                            <img class="white-icon" src="{{ asset('files/images/icons/training-white.svg') }}" alt="{{ __('Training image') }}">
                            <p> {{__('Sistem obuka')}} </p>
                        </div>
                        <div class="home-icon" link="">
                            <i class="fa-solid fa-calendar"></i>
                            <p> {{__('Kalendar aktivnosti')}} </p>
                        </div>
                        <div class="home-icon" link="">
                            <i class="fa-solid fa-user-pen"></i>
                            <p> {{__('Moje evaluacije')}} </p>
                        </div>
                        <div class="home-icon go-to" link="{{ route('system.user-data.my-profile') }}">
                            <i class="fa-solid fa-user"></i>
                            <p> {{__('Moj profil')}} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="homepage-side">
            <div class="reminders home-right-wrapper">
                <div class="home-right-header">
                    <p>Napomene</p>
                </div>
                <div class="home-right-element">
                    Danas, 11. Januar 2021 - Ponedjeljak, potrebno je da završim ovaj desni dio aplikacije !
                </div>
                <div class="home-right-element">
                    Ovdje upisujemo drugu napomenu !
                </div>
            </div>

            <div class="reminders home-right-wrapper">
                <div class="home-right-header">
                    <p> {{__('Brzi linkovi')}} </p>
                </div>
                <div class="home-right-element">
                    {{__('Podrška')}}
                </div>
                <div class="home-right-element">
                    {{__('Homepage')}}
                </div>
            </div>
        </div>
    </div>
@endsection
