@extends('admin.layout.layout')
@section('page-title') {{ $user->name ?? '' }} @endsection
@section('c-icon') <i class="fas fa-user"></i> @endsection
@section('c-title') {{ $user->name ?? '' }} @endsection
@section('c-breadcrumbs')
    <a> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.users') }}">{{ __('Pregled korisnika') }}</a> /
    <a href="{{ route('system.admin.users.preview', ['username' => $user->username ]) }}">{{ $user->name }}</a>
    @if(isset($edit))
        / <a href="#">{{ __('Uredi moj profil') }}</a>
    @endif
@endsection

@section('c-buttons')
    <a href="@if(Auth()->user()->role == 'trainer') {{ route('system.trainer-data.dashboard') }} @elseif(Auth()->user()->role == 'admin' or Auth()->user()->role == 'moderator') {{ route('system.home') }} @else @if(isset($preview)) {{ route('system.user-data.dashboard') }} @else {{ route('system.user-data.my-profile') }} @endif @endif">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @if(isset($preview))
        <a href="{{ route('system.user-data.my-profile.edit') }}" title="{{ __('Uredite lične podatke') }}">
            <button class="pm-btn btn pm-btn-edit">
                <i class="fas fa-edit"></i>
            </button>
        </a>
    @endif
@endsection

@section('content')
    <div class="content-wrapper preview-content-wrapper">
        <div class="form__info">
            <div class="form__info__inner">
                <form action="@if(isset($edit)) {{ route('system.user-data.my-profile.update') }} @endif" method="POST" id="js-form">
                    <div class="row">
                        @if(isset($preview))
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ html()->label(__('Ime i prezime'))->for('first_name')->class('bold') }}
                                    {{ html()->text('name', $user->name ?? '' )->class('form-control form-control-sm')->required()->value((isset($user) ? $user->name : ''))->isReadonly(isset($preview)) }}
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('Ime'))->for('first_name')->class('bold') }}
                                    {{ html()->text('first_name', $user->first_name ?? '' )->class('form-control form-control-sm')->required()->value((isset($user) ? $user->first_name : '')) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('Prezime'))->for('last_name')->class('bold') }}
                                    {{ html()->text('last_name', $user->last_name ?? '' )->class('form-control form-control-sm')->required()->value((isset($user) ? $user->last_name : '')) }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Email'))->for('email')->class('bold') }}
                                {{ html()->text('email')->class('form-control form-control-sm')->required()->maxlength(150)->value((isset($user) ? $user->email : ''))->isReadonly(isset($preview)) }}
                                <small id="emailHelp" class="form-text text-muted">{{ __('Unesite email') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Spol'))->for('country')->class('bold') }}
                                {{ html()->select('gender', $gender, isset($user) ? $user->gender : '1')->class('form-control form-control-sm mt-1 single-select2')->required()->disabled(isset($preview)) }}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Broj telefona'))->for('phone')->class('bold') }}
                                {{ html()->text('phone')->class('form-control form-control-sm mt-1')->required()->maxlength(13)->value((isset($user) ? $user->phone : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Datum rođenja'))->for('birth_date')->class('bold') }}
                                {{ html()->text('birth_date')->class(isset($preview) ? 'form-control form-control-sm mt-1' : 'form-control form-control-sm datepicker mt-1')->required()->maxlength(10)->value((isset($user) ? $user->birthDate() : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Adresa'))->for('address')->class('bold') }}
                                {{ html()->text('address')->class('form-control form-control-sm mt-1')->required()->maxlength(100)->value((isset($user) ? $user->address : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Grad'))->for('city')->class('bold') }}
                                {{ html()->select('city', $cities, isset($user) ? $user->city : '1')->class('form-control form-control-sm mt-1')->required()->disabled(isset($preview)) }}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Radno mjesto'))->for('workplace')->class('bold') }}
                                {{ html()->text('workplace')->class('form-control form-control-sm mt-1')->required()->maxlength(100)->value((isset($user) ? $user->workplace : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Institucija'))->for('institution')->class('bold') }}
                                {{ html()->select('institution', $institutions, isset($user) ? $user->institution : '1')->class('form-control form-control-sm mt-1 single-select2')->required()->disabled(isset($preview)) }}
                            </div>
                        </div>
                    </div>

                    @if(!isset($preview))
                        <div class="row mt-4">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="yellow-btn">  {{ __('AŽURIRAJTE') }} </button>
                            </div>
                        </div>
                    @endif
                </form>

                @if(isset($preview) and Auth()->user()->role == 'user' and Auth()->user()->myCertificates->count())
                    <div class="custom-hr"></div>

                    <div class="mp__certificates mb-32">
                        <h4>{{ __('Moji certifikati') }}</h4>
                        <div class="mp__cer__inner">
                            @foreach(Auth()->user()->myCertificates as $certifiate)
                                <a href="{{ route('system.user-data.trainings.apis.applications.download-certificate', ['application_id' => $certifiate->id]) }}">
                                    <div class="certificate">
                                        <p>{{ $certifiate->instanceRel->trainingRel->title ?? '' }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="right__menu__info">
            @include('user-data.profile.includes.right-menu')
        </div>
    </div>
@endsection
