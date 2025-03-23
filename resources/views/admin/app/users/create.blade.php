@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-users"></i> @endsection
@section('c-title') {{ __('Korisnici') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.users') }}">{{ __('Pregled svih korisnika') }}</a> /
    @if(!isset($user))
        <a href="#">{{ __('Unos') }}</a>
    @else
        <a href="{{ route('system.admin.users.preview', ['username' => $user->username ]) }}">{{ $user->name }}</a>
    @endif
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.users') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @if(isset($preview))
        <a href="{{ route('system.admin.users.edit', ['username' => $user->username ]) }}">
            <button class="pm-btn btn pm-btn-edit">
                <i class="fas fa-edit"></i>
            </button>
        </a>
    @endif
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        @if(session()->has('success'))
            <div class="alert alert-success mt-3">
                {{ session()->get('success') }}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger mt-3">
                {{ session()->get('error') }}
            </div>
        @endif

        <div class="form__info">
            <div class="form__info__inner">
                <form action="@if(isset($edit)) {{ route('system.admin.users.update') }} @else {{ route('system.admin.users.save') }} @endif" method="POST" id="js-form">

                    @if(isset($edit))
                        {{ html()->hidden('id')->class('form-control')->value($user->id) }}
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Ime'))->for('first_name')->class('bold') }}
                                {{ html()->text('first_name', $user->first_name ?? '' )->class('form-control form-control-sm')->required()->value((isset($user) ? $user->first_name : '')) }}
                                @if(!isset($preview)) <small id="first_nameHelp" class="form-text text-muted">{{ __('Unesite ime korisnika') }}</small> @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Prezime'))->for('last_name')->class('bold') }}
                                {{ html()->text('last_name', $user->last_name ?? '' )->class('form-control form-control-sm')->required()->value((isset($user) ? $user->last_name : '')) }}
                                @if(!isset($preview)) <small id="first_nameHelp" class="form-text text-muted">{{ __('Unesite prezime korisnika') }}</small> @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Email'))->for('email')->class('bold') }}
                                {{ html()->text('email')->class('form-control form-control-sm')->required()->maxlength(150)->value((isset($user) ? $user->email : ''))->isReadonly(isset($preview)) }}
                                @if(!isset($preview)) <small id="emailHelp" class="form-text text-muted">{{ __('Unesite korisničku email adresu') }}</small> @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Spol'))->for('gender')->class('bold') }}
                                {{ html()->select('gender', $gender, isset($user) ? $user->gender : '1')->class('form-control form-control-sm mt-1 single-select2')->required()->disabled(isset($preview)) }}
                                @if(!isset($preview)) <small id="genderHelp" class="form-text text-muted">{{ __('Odaberite spol') }}</small> @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Broj telefona'))->for('phone')->class('bold') }}
                                {{ html()->text('phone')->class('form-control form-control-sm mt-1')->required()->maxlength(13)->value((isset($user) ? $user->phone : '+387'))->isReadonly(isset($preview)) }}
                                @if(!isset($preview)) <small id="phoneHelp" class="form-text text-muted">{{ __('Unesite broj telefona') }}</small> @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Datum rođenja'))->for('birth_date')->class('bold') }}
                                {{ html()->text('birth_date')->class(isset($preview) ? 'form-control form-control-sm mt-1' : 'form-control form-control-sm datepicker mt-1')->required()->maxlength(10)->value((isset($user) ? $user->birthDate() : ''))->isReadonly(isset($preview)) }}
                                @if(!isset($preview)) <small id="birth_dateHelp" class="form-text text-muted">{{ __('Odaberite datum rođenja') }}</small> @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Adresa'))->for('address')->class('bold') }}
                                {{ html()->text('address')->class('form-control form-control-sm mt-1')->required()->maxlength(100)->value((isset($user) ? $user->address : ''))->isReadonly(isset($preview)) }}
                                @if(!isset($preview)) <small id="addressHelp" class="form-text text-muted">{{ __('Unesite adresu stanovanja') }}</small> @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Grad'))->for('city')->class('bold') }}
                                {{ html()->select('city', $cities, isset($user) ? $user->city : '')->class('form-control form-control-sm mt-1 single-select2')->required()->disabled(isset($preview)) }}
                                @if(!isset($preview)) <small id="cityHelp" class="form-text text-muted">{{ __('Unesite grad stanovanja') }}</small> @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Radno mjesto'))->for('workplace')->class('bold') }}
                                {{ html()->text('workplace')->class('form-control form-control-sm mt-1')->required()->maxlength(100)->value((isset($user) ? $user->workplace : ''))->isReadonly(isset($preview)) }}
                                @if(!isset($preview)) <small id="workplaceHelp" class="form-text text-muted">{{ __('Unesite naziv radnog mjesta') }}</small> @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Institucija'))->for('institution')->class('bold') }}
                                {{ html()->select('institution', $institutions, isset($user) ? $user->institution : '1')->class('form-control form-control-sm mt-1 single-select2')->required()->disabled(isset($preview)) }}
                                @if(!isset($preview)) <small id="institutionHelp" class="form-text text-muted">{{ __('Odaberite instituciju iz koje dolazi') }}</small> @endif
                            </div>
                        </div>
                    </div>

                        <div class="row mt-4">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="yellow-btn">  {{ __('AŽURIRAJTE') }} </button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
