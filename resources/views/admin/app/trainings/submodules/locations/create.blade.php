@extends('admin.layout.layout')
@section('c-icon') <i class="fa-solid fa-map"></i> @endsection
@section('c-title') {{ __('Lokacije') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">...</a> /
    <a href="{{ route('system.admin.trainings.submodules.locations') }}">{{ __('Pregled svih lokacija') }}</a> /
    @isset($create)
        <a href="#">{{ __('Unos') }}</a>
    @else
        <a href="#">{{ $location->title ?? '' }}</a>
    @endisset
@endsection

@section('c-buttons')
    <a href="@isset($edit) {{ route('system.admin.trainings.submodules.locations.preview', ['id' => $location->id ]) }} @else @endif{{ route('system.admin.trainings.submodules.locations') }}" title="{{ __('Nazad') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @isset($preview)
        <a href="{{ route('system.admin.trainings.submodules.locations.edit', ['id' => $location->id ]) }}" title="{{ __('Uredite lokaciju') }}">
            <button class="pm-btn pm-btn-white btn pm-btn-edit">
                <i class="fas fa-edit"></i>
            </button>
        </a>
        <a href="{{ route('system.admin.trainings.submodules.locations.delete', ['id' => $location->id ]) }}" title="{{ __('Obrišite lokaciju') }}">
            <button class="pm-btn pm-btn-white btn pm-btn-trash">
                <i class="fas fa-trash"></i>
            </button>
        </a>
    @endisset
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        <div class="row">
            <div class="col-md-12">
                <form action="@if(isset($edit)) {{ route('system.admin.trainings.submodules.locations.update') }} @else {{ route('system.admin.trainings.submodules.locations.save') }} @endif" method="POST" id="js-form">
                    @if(isset($edit))
                        {{ html()->hidden('id')->class('form-control')->value($location->id) }}
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Naziv'))->for('title')->class('bold') }}
                                {{ html()->text('title', $location->title ?? '' )->class('form-control form-control-sm')->required()->value((isset($location) ? $location->title : ''))->isReadonly(isset($preview))->maxlength(200) }}
                                <small id="titleHelp" class="form-text text-muted">{{ __('Naziv lokacije') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Adresa'))->for('address')->class('bold') }}
                                {{ html()->text('address', $location->address ?? '' )->class('form-control form-control-sm')->required()->value((isset($location) ? $location->address : ''))->isReadonly(isset($preview))->maxlength(200) }}
                                <small id="addressHelp" class="form-text text-muted">{{ __('Adresa gdje se lokacija nalazi') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Grad'))->for('city')->class('bold') }}
                                {{ html()->select('city', $cities, isset($location) ? $location->city : '')->class('form-control form-control-sm ' . (!(isset($preview)) ? 'select2' : ''))->required()->disabled(isset($preview)) }}
                                <small id="cityHelp" class="form-text text-muted">{{ __('Odaberite grad u kojem se nalazi') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Broj telefona'))->for('phone')->class('bold') }}
                                {{ html()->text('phone', $location->phone ?? '' )->class('form-control form-control-sm')->required()->value((isset($location) ? $location->phone : ''))->isReadonly(isset($preview))->maxlength(200) }}
                                <small id="phoneHelp" class="form-text text-muted">{{ __('Broj telefona u formatu +387 XX/XXX-XXX') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Email adresa'))->for('email')->class('bold') }}
                                {{ html()->text('email', $location->email ?? '' )->class('form-control form-control-sm')->required()->value((isset($location) ? $location->email : ''))->isReadonly(isset($preview))->maxlength(200) }}
                                <small id="emailHelp" class="form-text text-muted">{{ __('Email adresa za kontakt') }}</small>
                            </div>
                        </div>
                    </div>

                    @if(!isset($preview))
                        <div class="row mt-4">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="yellow-btn">  {{ __('SAČUVAJTE') }} </button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
