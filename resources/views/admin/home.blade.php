@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-home"></i> @endsection
@section('c-title') {{ __('Dashboard') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Upravljačka tabla admin panela') }}</p> </a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.home') }}">
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
                            <p>{{__('Programa')}}</p>
                        </div>
                        <div class="home-icon" title="{{__('Objavljenih obuka')}}">
                            <h1>{{$instances ?? '0'}}</h1>
                            <p>{{__('Obuka')}}</p>
                        </div>
                        <div class="home-icon" title="{{__('Registrovanih trenera')}}">
                            <h1>{{$trainers ?? '0'}}</h1>
                            <p>{{__('Trenera')}}</p>
                        </div>
                        <div class="home-icon" title="{{__('Registrovanih korisnika')}}">
                            <h1>{{$users ?? '0'}}</h1>
                            <p>{{__('Korisnika')}}</p>
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
                        <div class="home-icon go-to" link="{{ route('system.admin.trainings.home') }}" title="{{__('PSistem obuka')}}">
                            <img class="normal-icon" src="{{ asset('files/images/icons/training.svg') }}" alt="{{ __('Training image') }}">
                            <img class="white-icon" src="{{ asset('files/images/icons/training-white.svg') }}" alt="{{ __('Training image') }}">
                            <p> {{__('Sistem obuka')}} </p>
                        </div>
                        <div class="home-icon" link="">
                            <i class="fas fa-chart-area"></i>
                            <p> {{__('Izvještaji')}} </p>
                        </div>
                        <div class="home-icon go-to" link="{{ route('system.admin.trainings.submodules.trainers') }}">
                            <img class="normal-icon" src="{{ asset('files/images/icons/trainer.svg') }}" alt="{{ __('Training image') }}">
                            <img class="white-icon" src="{{ asset('files/images/icons/trainer-white.svg') }}" alt="{{ __('Training image') }}">
                            <p> {{__('Treneri')}} </p>
                        </div>
                        <div class="home-icon" link="">
                            <img class="normal-icon" src="{{ asset('files/images/icons/users.svg') }}" alt="{{ __('Training image') }}">
                            <img class="white-icon" src="{{ asset('files/images/icons/users-white.svg') }}" alt="{{ __('Training image') }}">
                            <p> {{__('Korisnici')}} </p>
                        </div>
                    </div>
                    <div class="home-row-items">
                        <div class="home-icon go-to" link="{{ route('system.admin.other.analysis') }}">
                            <i class="fa-solid fa-magnifying-glass-chart"></i>
                            <p>{{ __('Analiza potreba') }}</p>
                        </div>
                        <div class="home-icon go-to" link="{{ route('system.admin.other.internal-events') }}">
                            <i class="fa-solid fa-calendar-days"></i>
                            <p>{{ __('Interni događaji') }}</p>
                        </div>
                        <div class="home-icon go-to" link="{{ route('system.admin.other.bodies') }}">
                            <i class="fas fa-info-circle"></i>
                            <p>{{ __('Organi i tijela') }}</p>
                        </div>
                        <div class="home-icon" link="">
                            <i class="fas fa-cogs"></i>
                            <p>{{ __('Postavke') }}</p>
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
