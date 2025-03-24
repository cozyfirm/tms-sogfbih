@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-cogs"></i> @endsection
@section('c-title') {{ __('Postavke') }} @endsection
@section('c-breadcrumbs')
    <a href="{{ route('system.home') }}"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.core') }}"> <p>{{ __('Postavke') }}</p> </a>
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
                    <h4> {{__('ADMINISTRATORSKE POSTAVKE')}} </h4>
                </div>

                <div class="home-row-body">
                    <div class="home-row-items">
                        <div class="home-icon go-to" link="{{ route('system.admin.core.settings.cities') }}" title="{{ __('Pregled općina i gradova') }}">
                            <i class="fas fa-building"></i>
                            <p> {{__('Općine i gradovi')}} </p>
                        </div>
                        <div class="home-icon go-to" link="{{ route('system.admin.core.keywords') }}" title="{{ __('Pregled šifarnika') }}">
                            <i class="fa-solid fa-unlock-keyhole"></i>
                            <p> {{__('Šifarnici')}} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="homepage-side">
            @include('admin.app.shared.snippets.home-menu')
        </div>
    </div>
@endsection
