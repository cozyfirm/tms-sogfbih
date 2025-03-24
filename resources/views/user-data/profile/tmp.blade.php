@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-user"></i> @endsection
@section('c-title') {{ __('Moj profil') }} @endsection
@section('c-breadcrumbs')
    <a href="{{ route('system.user-data.dashboard') }}"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.users') }}">{{ __('Pregled korisnika') }}</a> /
    <a href="{{ route('system.admin.users.preview', ['username' => $user->username ]) }}">{{ $user->name }}</a>
    @if(isset($edit))
        / <a href="#">{{ __('Uredi moj profil') }}</a>
    @endif
@endsection

@section('c-buttons')
    <a href="@if(isset($preview)) {{ route('system.user-data.dashboard') }} @else {{ route('system.user-data.my-profile') }} @endif">
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
    <div class="content-wrapper content-wrapper-p-15">
        <div class="row">
            <div class="@if(isset($preview)) col-md-9 @else col-md-12 @endif">
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
                                {{ html()->select('gender', $gender, isset($user) ? $user->gender : '1')->class('form-control form-control-sm mt-1')->required()->disabled(isset($preview)) }}
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
                                {{ html()->select('city', ['1' => 'Sarajevo', '2' => 'Vakuf gornji'], isset($user) ? $user->city : '1')->class('form-control form-control-sm mt-1')->required()->disabled(isset($preview)) }}
                            </div>
                        </div>
                    </div>

                    <hr class="mt-4 mb-4">

                    <div class="row mt-1">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Radno mjesto'))->for('workplace')->class('bold') }}
                                {{ html()->text('workplace')->class('form-control form-control-sm mt-1')->required()->maxlength(100)->value((isset($user) ? $user->workplace : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Institucija'))->for('institution')->class('bold') }}
                                {{ html()->select('institution', ['1' => 'Sarajevo', '2' => 'Vakuf gornji'], isset($user) ? $user->institution : '1')->class('form-control form-control-sm mt-1')->required()->disabled(isset($preview)) }}
                            </div>
                        </div>
                    </div>
                    @if($user->comment != '')
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ html()->label(__('Komentar'))->for('comment')->class('bold') }}
                                    {{ html()->textarea('comment')->class('form-control form-control-sm mt-1')->required()->maxlength(500)->style('height:80px;')->value((isset($user) ? $user->comment : ''))->isReadonly(isset($preview)) }}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!isset($preview))
                        <div class="row mt-4">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="yellow-btn">  {{ __('AŽURIRAJTE') }} </button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>


            @if(isset($preview))
                <div class="col-md-3 border-left">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card p-0 m-0" title="#">
                                <div class="card-body d-flex justify-content-between">
                                    <h5 class="p-0 m-0"> {{ __('Ostale informacije') }} </h5>
                                    <i class="fas fa-info mt-1 mr-1"></i>
                                </div>
                            </div>


                            <form action="{{ route('system.admin.users.update-profile-image') }}" method="POST" id="update-profile-image" enctype="multipart/form-data">
                                @csrf
                                {{ html()->hidden('id')->class('form-control')->value($user->id) }}
                                <div class="card p-0 m-0 mt-3" title="{{ __('Nova fotografija za program') }}">
                                    <div class="card-body d-flex justify-content-between">
                                        <label for="photo_uri" >
                                            <p class="m-0">{{ __('Ažurirajte fotografiju') }}</p>
                                        </label>
                                        <i class="fas fa-image mt-1"></i>
                                    </div>
                                    <input name="photo_uri" class="form-control form-control-lg d-none" id="photo_uri" type="file">
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>
@endsection
