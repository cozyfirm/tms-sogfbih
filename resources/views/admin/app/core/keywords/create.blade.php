@extends('admin.layout.layout')
@section('c-icon') <i class="fa-solid fa-unlock-keyhole"></i> @endsection
@section('c-title') {{ $keyword }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">..</a> /
    <a href="{{ route('system.admin.core.keywords.new-instance', ['key' => $key]) }}">{{ __('Šifarnici') }}</a> /
    <a href="#">{{ __('Unos - Pregled') }}</a>
@endsection
@section('c-buttons')
    @if(isset($edit))
        <a href="{{ route('system.admin.core.keywords.delete-instance', ['id' => $instance->id ]) }}">
            <button class="pm-btn btn btn-danger"> <i class="fas fa-trash"></i> </button>
        </a>
    @endif
    <a href="{{ route('system.admin.core.keywords.preview-instances', ['key' => $key]) }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        <form action="@if(isset($edit)) {{ route('system.admin.core.keywords.update-instance') }} @else {{ route('system.admin.core.keywords.save-instance') }} @endif" method="POST">
            @csrf
            @if(isset($edit))
                {{ html()->hidden('id')->class('form-control')->value($instance->id) }}
            @endif
            {{ html()->hidden('type')->class('form-control')->value($key) }}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {{ html()->label(__('Vrijednost'))->for('name')->class('bold') }}
                        {{ html()->text('name')->class('form-control form-control-sm mt-2')->required()->maxlength(100)->value((isset($instance) ? $instance->name : '')) }}
                        <small id="nameHelp" class="form-text text-muted">{{ __('Prikazana vrijednost šifarnika') }}</small>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {{ html()->label(__('Opis'))->for('description')->class('bold') }}
                        {{ html()->textarea('description')->class('form-control form-control-sm mt-2')->maxlength(100)->value((isset($instance) ? $instance->description : ''))->style('height:120px') }}
                        <small id="descriptionHelp" class="form-text text-muted">{{ __('Eventualni kratki opis šifarnika') }}</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-dark btn-sm"> {{ __('SAČUVAJTE') }} </button>
                </div>
            </div>
        </form>
    </div>
@endsection
