@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-users"></i> @endsection
@section('c-title') {{ __('Korisnici') }} @endsection
@section('c-breadcrumbs')
    <a href="{{ route('system.home') }}"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.users') }}">{{ __('Pregled svih korisnika') }}</a> /
    <a href="{{ route('system.admin.users.preview', ['username' => $user->username ]) }}">{{ $user->name }}</a>
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
    <div class="content-wrapper preview-content-wrapper">
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
                <form action="#" method="POST" id="js-form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Ime i prezime'))->for('first_name')->class('bold') }}
                                {{ html()->text('name', $user->name ?? '' )->class('form-control form-control-sm')->required()->value((isset($user) ? $user->name : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Email'))->for('email')->class('bold') }}
                                {{ html()->text('email')->class('form-control form-control-sm')->required()->maxlength(150)->value((isset($user) ? $user->email : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Spol'))->for('gender')->class('bold') }}
                                {{ html()->select('gender', $gender, isset($user) ? $user->gender : '1')->class('form-control form-control-sm mt-1 single-select2')->required()->disabled(isset($preview)) }}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Broj telefona'))->for('phone')->class('bold') }}
                                {{ html()->text('phone')->class('form-control form-control-sm mt-1')->required()->maxlength(13)->value((isset($user) ? $user->phone : '+387'))->isReadonly(isset($preview)) }}
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
                                {{ html()->select('city', $cities, isset($user) ? $user->city : '')->class('form-control form-control-sm mt-1 single-select2')->required()->disabled(isset($preview)) }}
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
                </form>

                @if(isset($preview) and $user->role == 'user')
                    <div class="custom-hr"></div>

                    <div class="training__authors mb-32">
                        <h4>{{ __('Pregled certifikata') }}</h4>
                        <div class="authors">
                            <a href="#">
                                <div class="author__w training-check-author">
                                    <p>Program za inostrane zaposlenike</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="right__menu__info">
            @include('admin.app.users.snippets.right-menu')
        </div>
    </div>
@endsection
