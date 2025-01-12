@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/training.svg') }}" alt="{{ __('Training image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/training-yellow.svg') }}" alt="{{ __('Training image') }}">
@endsection
@section('c-title') {{ __('Sistem obuka') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Sistem obuka') }}</p> </a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.home') }}">
        <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>
    </a>
@endsection

@section('content')
    <div class="homepage">
        <div class="homepage-main">
            <div class="home-row">
                <div class="home-row-header">
                    <h4> {{__('SISTEM OBUKA')}} </h4>
                </div>

                <div class="home-row-body">
                    <div class="home-row-items">
                        <div class="home-icon go-to" link="{{ route('system.admin.trainings') }}" title="{{ __('Pregled svih programa obuka') }}">
                            <img class="normal-icon" src="{{ asset('files/images/icons/program.svg') }}" alt="{{ __('Training image') }}">
                            <img class="white-icon" src="{{ asset('files/images/icons/program-white.svg') }}" alt="{{ __('Training image') }}">
                            <p> {{__('Programi obuka')}} </p>
                        </div>
                        <div class="home-icon" link="">
                            <img class="normal-icon" src="{{ asset('files/images/icons/training-instance.svg') }}" alt="{{ __('Training-instance image') }}">
                            <img class="white-icon" src="{{ asset('files/images/icons/training-instance-white.svg') }}" alt="{{ __('Training instance image') }}">
                            <p> {{__('Instance obuka')}} </p>
                        </div>
                        <div class="home-icon" link="">
                            <i class="fa-solid fa-user-pen"></i>
                            <p> {{__('Evaluacije')}} </p>
                        </div>
{{--                        <div class="home-icon" link="">--}}
{{--                            <img class="normal-icon" src="{{ asset('files/images/icons/users.svg') }}" alt="{{ __('Training image') }}">--}}
{{--                            <img class="white-icon" src="{{ asset('files/images/icons/users-white.svg') }}" alt="{{ __('Training image') }}">--}}
{{--                            <p> {{__('Korisnici')}} </p>--}}
{{--                        </div>--}}
                    </div>
{{--                    <div class="home-row-items">--}}
{{--                        <div class="home-icon" link="" title="{{__('Pregled svih narudžbi')}}">--}}
{{--                            <i class="fa-solid fa-magnifying-glass-chart"></i>--}}
{{--                            <p>{{ __('Analiza potreba') }}</p>--}}
{{--                        </div>--}}
{{--                        <div class="home-icon" link="">--}}
{{--                            <i class="fa-solid fa-calendar-days"></i>--}}
{{--                            <p>{{ __('Interni događaji') }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
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
