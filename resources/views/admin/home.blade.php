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
                            <h1> {{$devices ?? '0'}}</h1>
                            <p>{{__('Programa')}}</p>
                        </div>
                        <div class="home-icon" title="{{__('Objavljenih obuka')}}">
                            <h1>{{$inTransit ?? '0'}}</h1>
                            <p>{{__('Obuka')}}</p>
                        </div>
                        <div class="home-icon" title="{{__('Registrovanih trenera')}}">
                            <h1>{{$inCart ?? '0'}}</h1>
                            <p>{{__('Trenera')}}</p>
                        </div>
                        <div class="home-icon" title="{{__('Registrovanih korisnika')}}">
                            <h1>{{$spentMoney ?? '0'}}</h1>
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
                        <div class="home-icon" link="" title="{{__('Podesite vrijeme kada su uređaji aktivni')}}">
                            <i class="far fa-clock"></i>
                            <p> {{__('Aktivni sati')}} </p>
                        </div>
                        <div class="home-icon" link="">
                            <i class="fas fa-plus"></i>
                            <p> {{__('Sinhronizujte uređaj')}} </p>
                        </div>
                        <div class="home-icon" link="">
                            <i class="fas fa-laptop-house"></i>
                            <p> {{__('Pametna kuća')}} </p>
                        </div>
                        <div class="home-icon" link="">
                            <i class="fas fa-wave-square"></i>
                            <p> {{__('Analitika')}} </p>
                        </div>
                    </div>
                    <div class="home-row-items">
                        <div class="home-icon" link="" title="{{__('Pregled svih narudžbi')}}">
                            <i class="fas fa-history"></i>
                            <p>Historija kupovanja</p>
                        </div>
                        <div class="home-icon" link="">
                            <i class="fas fa-cogs"></i>
                            <p>Popravka uređaja</p>
                        </div>
                        <div class="home-icon" link="">
                            <i class="fas fa-info-circle"></i>
                            <p>Uputstva za korištenje</p>
                        </div>
                        <div class="home-icon" link="">
                            <i class="far fa-lightbulb"></i>
                            <p>Novi uređaji</p>
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
