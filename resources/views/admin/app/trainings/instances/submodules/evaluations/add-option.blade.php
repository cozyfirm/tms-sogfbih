@extends('admin.layout.layout')
@section('c-icon')
    <i class="fa-solid fa-user-pen"></i>
@endsection
@section('c-title') {{ __('Evaluacije na obuci') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">{{ __('..') }}</a> /
    <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}">{{ $instance->trainingRel->title ?? '' }}</a> /
    <a href="{{ route('system.admin.trainings.instances.submodules.evaluations.preview', ['instance_id' => $instance->id ]) }}">{{ __('Evaluacije') }}</a> /
    <a href="#">{{ __('Pitanja') }}</a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.admin.trainings.instances.submodules.evaluations.preview', ['instance_id' => $instance->id ]) }}" title="{{ __('Nazad na obuku') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @isset($preview)
        @if(!$evaluation->locked)
            <a href="{{ route('system.admin.trainings.instances.submodules.evaluations.edit-option', ['id' => $option->id ]) }}">
                <button class="pm-btn pm-btn-white btn pm-btn-edit">
                    <i class="fas fa-edit"></i>
                </button>
            </a>
            <a href="{{ route('system.admin.trainings.instances.submodules.evaluations.delete-option', ['id' => $option->id ]) }}">
                <button class="pm-btn pm-btn-white btn pm-btn-trash">
                    <i class="fas fa-trash"></i>
                </button>
            </a>
        @endif
    @endisset
@endsection


@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        <div class="row">
            <div class="col-md-12">
                <form action="@if(isset($edit)) {{ route('system.admin.trainings.instances.submodules.evaluations.update-option') }} @else {{ route('system.admin.trainings.instances.submodules.evaluations.save-option') }} @endif" method="POST" id="js-form">
                    @if(isset($edit))
                        {{ html()->hidden('id')->class('form-control')->value($option->id) }}
                    @endif

                    {{ html()->hidden('instance_id')->class('form-control')->value($instance->id) }}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Grupa pitanja'))->for('group_by')->class('bold') }}
                                {{ html()->select('group_by', $groups, $option->group_by ?? '')->class('form-control form-control-sm single-select2')->required()->disabled(isset($preview)) }}
                                <small id="group_byHelp" class="form-text text-muted">{{ __('Grupa pitanja na evaluaciji') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Vrsta pitanja'))->for('type')->class('bold') }}
                                {{ html()->select('type', $types, $option->type ?? 'with_answers')->class('form-control form-control-sm single-select2')->required()->disabled(isset($preview)) }}
                                <small id="typeHelp" class="form-text text-muted">{{ __('Odaberite vrstu pitanja') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Pitanje'))->for('question')->class('bold') }}
                                {{ html()->text('question', $instance->question ?? '' )->class('form-control form-control-sm')->required()->value((isset($option) ? $option->question : ''))->isReadonly(isset($preview)) }}
                                <small id="questionHelp" class="form-text text-muted">{{ __('Unesite pitanje') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Dodatni opis'))->for('description')->class('bold') }}
                                {{ html()->textarea('description')->class('form-control form-control-sm')->maxlength(500)->value((isset($option) ? $option->description : ''))->isReadonly(isset($preview)) }}
                                <small id="descriptionHelp" class="form-text text-muted">{{ __('Dodatni opis koji se odnosi na pitanje') }}</small>
                            </div>
                        </div>
                    </div>

                    @if(!isset($preview))
                        <div class="row mt-4">
                            <div class="col-md-12 d-flex justify-content-end">
                                @isset($create)
                                    <div class="form-check form-check-inline ag_repeat_wrapper">
                                        <input class="form-check-input" type="checkbox" id="repeat" name="repeat">
                                        <label class="form-check-label" for="repeat">{{ __('Ponovite unos') }}</label>
                                    </div>
                                    <button type="submit" class="yellow-btn">  {{ __('SAČUVAJTE') }} </button>

                                @else
                                    <button type="submit" class="yellow-btn">  {{ __('AŽURIRAJTE') }} </button>
                                @endisset
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

