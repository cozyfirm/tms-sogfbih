@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/program.svg') }}" alt="{{ __('Training image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/program-yellow.svg') }}" alt="{{ __('Training image') }}">
@endsection
@section('c-title') {{ __('Programi obuka') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">...</a> /
    <a href="{{ route('system.admin.trainings') }}">{{ __('Pregled svih programa obuka') }}</a> /
    @isset($create)
        <a href="#">{{ __('Unos') }}</a>
    @else
        <a href="#">{{ $training->title ?? '' }}</a>
    @endisset
@endsection

@section('c-buttons')
    @isset($create)
        <a href="{{ route('system.admin.trainings') }}" title="{{ __('Pregled svih programa obuka') }}">
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
                <form action="@if(isset($edit)) {{ route('system.admin.trainings.update') }} @else {{ route('system.admin.trainings.save') }} @endif" method="POST" id="js-form">
                    @if(isset($edit))
                        {{ html()->hidden('id')->class('form-control')->value($training->id) }}
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Naziv'))->for('title')->class('bold') }}
                                {{ html()->text('title', $training->title ?? '' )->class('form-control form-control-sm')->required()->value((isset($training) ? $training->title : ''))->isReadonly(isset($preview))->maxlength(200) }}
                                <small id="titleHelp" class="form-text text-muted">{{ __('Naziv programa obuke') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Izradu programa obuke finansirao'))->for('financed_by')->class('bold') }}
                                {{ html()->select('financed_by', $financiers, isset($training) ? $training->financed_by : '')->class('form-control form-control-sm')->required()->disabled(isset($preview)) }}
                                <small id="financed_byHelp" class="form-text text-muted">{{ __('Odaberite izvor finansiranja programa obuke') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Učesnici programa'))->for('participants')->class('bold') }}
                                {{ html()->select('participants', $participants, isset($training) ? $training->participants : '')->class('form-control form-control-sm')->required()->disabled(isset($preview)) }}
                                <small id="participantsHelp" class="form-text text-muted">{{ __('Za koje učesnike je ovaj program namijenjen?') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Program obuke izrađen u okviru projekta'))->for('project')->class('bold') }}
                                {{ html()->select('project', $projects, isset($training) ? $training->project : '')->class('form-control form-control-sm')->required()->disabled(isset($preview)) }}
                                <small id="projectHelp" class="form-text text-muted">{{ __('Odaberite projekt u čijem je okviru izrađen program obuka') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Godina'))->for('year')->class('bold') }}
                                {{ html()->number('year', '', '2000', (date('Y') + 5) )->class('form-control form-control-sm')->required()->value((isset($training) ? $training->year : date('Y')))->isReadonly(isset($preview)) }}
                                <small id="yearHelp" class="form-text text-muted">{{ __('Godina izrade projekta') }}</small>
                            </div>
                        </div>
                    </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ html()->label(__('Šira oblast kojoj pripada'))->for('areas')->class('bold') }}

                                    <select name="areas" class="form-control form-control-sm select2" required multiple>
                                        @foreach($areas as $key => $val)
                                            <option value="{{ $key }}" @isset($training) @if(TrainingHelper::isSelected($training->id, $key)) selected @endif @endisset>{{ $val }}</option>
                                        @endforeach
                                    </select>

                                    <small id="projectHelp" class="form-text text-muted">{{ __('Odaberite šire oblasti kojima program pripada (višestruki unos omogućen)') }}</small>
                                </div>
                            </div>
                        </div>

                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="submit" class="yellow-btn">  {{ __('SAČUVAJTE') }} </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
