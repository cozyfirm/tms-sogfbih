@extends('admin.layout.layout')
@section('c-icon')<i class="fas fa-user"></i> @endsection
@section('c-title') {{ __('Kreiranje prijava') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">{{ __('..') }}</a> /
    <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}">{{ $instance->trainingRel->title ?? '' }}</a> /
    <a href="#">{{ __('Kreiranje prijava') }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}" title="{{ __('Nazad na pregled obuke') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('system.admin.trainings.instances.submodules.applications.save-application') }}" method="POST" id="js-form">
                    {{ html()->hidden('instance_id')->class('form-control')->value($instance->id) }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Ime i prezime'))->for('user_id')->class('bold') }}
                                {{ html()->select('user_id', $users, '')->class('form-control required form-control-sm single-select2')->required() }}
                                <small id="user_idHelp" class="form-text text-muted">{{ __('Odaberite korisnika/cu kojeg/u želite prijaviti na obuku') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Prisustvo'))->for('presence')->class('bold') }}
                                {{ html()->select('presence', ['0' => 'Ne', '1' => 'Da'], '1')->class('form-control required form-control-sm single-select2')->required() }}
                                <small id="presenceHelp" class="form-text text-muted">{{ __('Da li je korisnik/ca bio prisutan/na na obuci?') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Certifikat'))->for('certificate')->class('bold') }}
                                {{ html()->select('certificate', ['0' => 'Ne', '1' => 'Da'], '1')->class('form-control required form-control-sm single-select2')->required() }}
                                <small id="certificateHelp" class="form-text text-muted">{{ __('Da li će se kreirati certifikat?') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-end">
                            <div class="form-check form-check-inline ag_repeat_wrapper">
                                <input class="form-check-input" type="checkbox" id="repeat" name="repeat">
                                <label class="form-check-label" for="repeat">{{ __('Ponovite unos') }}</label>
                            </div>

                            <button type="submit" class="yellow-btn">  {{ __('SAČUVAJTE') }} </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
