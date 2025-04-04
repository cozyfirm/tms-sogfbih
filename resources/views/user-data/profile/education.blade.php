@extends('admin.layout.layout')
@section('page-title') {{ (Auth()->user()->name ?? '') . __(' - stručna sprema') }} @endsection
@section('c-icon') <i class="fa-solid fa-building-columns"></i> @endsection
@section('c-title') {{ __('Stručna sprema') }} @endsection
@section('c-breadcrumbs')
    <a href="{{ route('system.user-data.dashboard') }}"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.users') }}">{{ __('Pregled korisnika') }}</a> /
    <a href="{{ route('system.admin.users.preview', ['username' => $user->username ]) }}">{{ $user->name }}</a> /
    <a href="#">{{ __('Stručna sprema') }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.user-data.my-profile') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>
@endsection

@section('content')
    <div class="content-wrapper preview-content-wrapper">
        <div class="form__info">
            <div class="form__info__inner">
                <form action="{{ route('system.user-data.my-profile.education.update') }}" method="POST" id="js-form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Stepen stručne spreme'))->for('level')->class('bold') }}
                                {{ html()->select('level', $educationLevels, isset($education) ? $education->level : '')->class('form-control form-control-sm mt-2 single-select2')->options([])->style('width:100%;') }}
                                <small id="levelHelp" class="form-text text-muted"> {{ __('Unesite Vaš stepen stručne spreme') }} </small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Škola / Fakultet'))->for('school')->class('bold') }}
                                {{ html()->text('school')->class('form-control form-control-sm mt-2')->maxlength(100)->value(isset($education) ? $education->school : '') }}
                                <small id="schoolHelp" class="form-text text-muted"> {{ __('Unesite školu / fakultet ') }} </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Univerzitet'))->for('university')->class('bold') }}
                                {{ html()->text('university')->class('form-control form-control-sm mt-2')->maxlength(100)->value(isset($education) ? $education->university : '') }}
                                <small id="universityHelp" class="form-text text-muted"> {{ __('Unesite naziv univerziteta') }} </small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Stečeno zvanje'))->for('title')->class('bold') }}
                                {{ html()->text('title')->class('form-control form-control-sm mt-2')->maxlength(100)->value(isset($education) ? $education->title : '') }}
                                <small id="titleHelp" class="form-text text-muted"> {{ __('Vaše stečeno zvanje') }} </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Datum diplomiranja'))->for('graduation_date')->class('bold') }}
                                {{ html()->text('graduation_date')->class('form-control form-control-sm mt-2 datepicker')->maxlength(100)->value(isset($education) ? $education->date() : '') }}
                                <small id="graduation_dateHelp" class="form-text text-muted"> {{ __('Neobavezno polje') }} </small>
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

        <div class="right__menu__info">
            @include('user-data.profile.includes.right-menu')
        </div>
    </div>
@endsection
