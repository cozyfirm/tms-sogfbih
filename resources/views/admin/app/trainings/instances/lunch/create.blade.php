@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/training-instance.svg') }}" alt="{{ __('Training-instance image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/training-instance-yellow.svg') }}" alt="{{ __('Training instance image') }}">
@endsection
@section('c-title') {{ __('Informacije o ručku') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">...</a> /
    <a href="{{ route('system.admin.trainings.instances') }}">{{ __('Instance obuka') }}</a> /
    <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}">{{ __('Obuka') }}</a> /

    @isset($create)
        <a href="#">{{ __('Unos') }}</a>
    @else
        <a href="#">{{ $training->title ?? '' }}</a>
    @endisset
@endsection

@section('c-buttons')
    @isset($create)
        <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}" title="{{ __('Nazad na pregled obuke') }}">
            <button class="pm-btn btn pm-btn-info">
                <i class="fas fa-chevron-left"></i>
                <span>{{ __('Nazad') }}</span>
            </button>
        </a>
    @else
        <a href="{{ route('system.admin.trainings.preview', ['id' => $training->id ]) }}" title="{{ __('Nazad na pregled programa obuke') }}">
            <button class="pm-btn btn pm-btn-info">
                <i class="fas fa-chevron-left"></i>
                <span>{{ __('Nazad') }}</span>
            </button>
        </a>
    @endisset
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        <div class="row">
            <div class="col-md-12">
                <form action="@if(isset($edit)) {{ route('system.admin.trainings.instances.lunch.update') }} @else {{ route('system.admin.trainings.instances.lunch.save') }} @endif" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Instance ID -->
                    {{ html()->hidden('instance_id')->class('form-control')->value($instance->id) }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Restoran'))->for('restaurant')->class('bold') }}
                                {{ html()->text('restaurant', $lunch->restaurant ?? '' )->class('form-control form-control-sm')->required()->value((isset($lunch) ? $lunch->restaurant : ''))->isReadonly(isset($preview)) }}
                                <small id="restaurantHelp" class="form-text text-muted">{{ __('Unesite naziv restorana') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Adresa'))->for('address')->class('bold') }}
                                {{ html()->text('address', $lunch->address ?? '' )->class('form-control form-control-sm')->required()->value((isset($lunch) ? $lunch->address : ''))->maxlength('200')->isReadonly(isset($preview)) }}
                                <small id="addressHelp" class="form-text text-muted">{{ __('Naziv i broj ulice restorana') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Kontakt telefon'))->for('phone')->class('bold') }}
                                {{ html()->text('phone', $lunch->phone ?? '' )->class('form-control form-control-sm')->required()->value((isset($lunch) ? $lunch->phone : '+387 '))->maxlength('50')->isReadonly(isset($preview)) }}
                                <small id="phoneHelp" class="form-text text-muted">{{ __('Broj telefona u formatu +387 XX/XXX-XXX') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Email adresa'))->for('email')->class('bold') }}
                                {{ html()->text('email', $lunch->email ?? '' )->class('form-control form-control-sm')->required()->value((isset($lunch) ? $lunch->email : ''))->maxlength('50')->isReadonly(isset($preview)) }}
                                <small id="emailHelp" class="form-text text-muted">{{ __('Email adresa za kontakt') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Iznos računa'))->for('cost')->class('bold') }}
                                {{ html()->text('cost', $lunch->cost ?? '' )->class('form-control form-control-sm')->required()->value((isset($lunch) ? $lunch->cost : ''))->maxlength('50')->isReadonly(isset($preview)) }}
                                <small id="costHelp" class="form-text text-muted">{{ __('Iznos računa u restoranu za obrok') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Faktura / Račun'))->for('invoice')->class('bold') }}
                                <input class="form-control form-control-sm" id="invoice" name="invoice" type="file">
                                <small id="invoiceHelp" class="form-text text-muted">{{ __('Priložite fakturu i/ili račun u .pdf formatu') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-end gap-5">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="repeat" name="repeat">
                                <label class="form-check-label" for="repeat">Ponovite unos</label>
                            </div>

                            <button type="submit" class="yellow-btn">  {{ __('SAČUVAJTE') }} </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
