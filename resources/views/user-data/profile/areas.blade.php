@extends('admin.layout.layout')
@section('page-title') {{ ($user->name ?? '') . __(' - oblasti') }} @endsection
@section('c-icon') <img src="{{ asset('files/images/icons/category.svg') }}" alt="{{ __('Area image') }}"> @endsection
@section('c-title') {{ __('Oblasti') }} @endsection
@section('c-breadcrumbs')
    <a href="{{ route('system.home') }}"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.trainings.home') }}">{{ __('Sistem obuka') }}</a> /
    <a href="{{ route('system.admin.trainings.submodules.trainers') }}">{{ __('Pregled svih trenera') }}</a> /
    <a href="{{ route('system.admin.users.preview', ['username' => $user->username ]) }}">{{ $user->name }}</a> /
    <a href="#">{{ __('Oblasti') }}</a>
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
    <div class="content-wrapper content-wrapper-p-15">
        <div class="form__info">
            <div class="form__info__inner">
                <form action="{{ route('system.user-data.my-profile.areas.update') }}" method="POST" id="js-form">

                    {{ html()->hidden('user_id')->class('form-control')->value($user->id) }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Oblasti'))->for('areas')->class('bold') }}

                                <select name="areas" class="form-control form-control-sm select2" required multiple>
                                    @foreach($areas as $key => $val)
                                        <option value="{{ $key }}" @isset($user) @if(UserHelper::isSelected($user->id, $key)) selected @endif @endisset>{{ $val }}</option>
                                    @endforeach
                                </select>

                                <small id="areasHelp" class="form-text text-muted"> {{ __('Odaberite oblasti iz koje trener predstavlja ekspertizu') }} </small>
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
