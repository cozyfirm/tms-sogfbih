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
    <a href="#">{{ $training->title ?? '' }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.trainings') }}" title="{{ __('Pregled svih programa obuka') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @if(isset($preview))
        <a href="{{ route('system.admin.trainings.edit', ['id' => $training->id ]) }}">
            <button class="pm-btn pm-btn-white btn pm-btn-edit">
                <i class="fas fa-edit"></i>
            </button>
        </a>
        <a href="{{ route('system.admin.trainings.delete', ['id' => $training->id ]) }}">
            <button class="pm-btn pm-btn-white btn pm-btn-trash">
                <i class="fas fa-trash"></i>
            </button>
        </a>
    @endif
@endsection

@section('content')
    <!-- Add or edit author -->
    @include('admin.app.trainings.snippets.add-author')

    <!-- Upload files GUI -->
    {{ html()->hidden('image_path')->class('form-control image_path')->value(public_path('files/upload/trainings')) }}
    {{ html()->hidden('file_path')->class('form-control file_path')->value(storage_path('files/trainings/trainings')) }}
    {{ html()->hidden('model_id')->class('form-control model_id')->value($training->id) }}
    {{ html()->hidden('upload_route')->class('form-control upload_route')->value(route('system.admin.trainings.save-files')) }}
    @include('admin.app.shared.files.file-upload')

    <div class="content-wrapper preview-content-wrapper">
        <div class="form__info">
            <div class="form__info__inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ html()->label(__('Naziv programa obuke'))->for('title')->class('bold') }}
                            {{ html()->text('title', $training->title ?? '' )->class('form-control form-control-sm')->required()->value((isset($training) ? $training->title : ''))->isReadonly(isset($preview))->maxlength(200) }}
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Izradu programa obuke finansirao'))->for('financed_by')->class('bold') }}
                            {{ html()->select('financed_by', $financiers, isset($training) ? $training->financed_by : '')->class('form-control form-control-sm')->required()->disabled(isset($preview)) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Učesnici programa'))->for('participants')->class('bold') }}
                            {{ html()->select('participants', $participants, isset($training) ? $training->participants : '')->class('form-control form-control-sm')->required()->disabled(isset($preview)) }}
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Program obuke izrađen u okviru projekta'))->for('project')->class('bold') }}
                            {{ html()->select('project', $projects, isset($training) ? $training->project : '')->class('form-control form-control-sm')->required()->disabled(isset($preview)) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Godina izrade projekta'))->for('year')->class('bold') }}
                            {{ html()->number('year', '', '2000', (date('Y') + 5) )->class('form-control form-control-sm')->required()->value((isset($training) ? $training->year : date('Y')))->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                </div>

                <div class="custom-hr"></div>

                <!-- Authors of training programs -->
                @if($training->authorsRel->count())
                    <div class="training__authors mb-32">
                        <h4>{{ __('Autori programa obuke') }}</h4>
                        <div class="authors">
                            @foreach($training->authorsRel as $author)
                                <a href="#">
                                    <div class="author__w training-check-author" author-id="{{ $author->author_id ?? 0 }}">
                                        <p>{{ $author->authorRel->title ?? '' }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="training__areas">
                    <h4>{{ __('Šire oblasti kojima program pripada') }}</h4>
                    <div class="areas">
                        @foreach($training->areasRel as $area)
                            <div class="area__w">
                                <p>{{ $area->areaRel->name ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="right__menu__info">
            @include('admin.app.trainings.snippets.right-menu')
        </div>
    </div>
@endsection
