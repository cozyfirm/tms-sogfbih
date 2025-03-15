@extends('admin.layout.layout')
@section('c-icon') <i class="fa-solid fa-magnifying-glass-chart"></i> @endsection
@section('c-title') {{ __('Analize potreba za obukama') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.other.analysis') }}">{{ __('Analiza potreba za obukama') }}</a> /
    <a href="#">{{ $analysis->title ?? '' }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.other.analysis') }}" title="{{ __('Nazad') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @if(isset($preview))
        <a href="{{ route('system.admin.other.analysis.edit', ['id' => $analysis->id ]) }}">
            <button class="pm-btn pm-btn-white btn pm-btn-edit">
                <i class="fas fa-edit"></i>
            </button>
        </a>
        <a href="{{ route('system.admin.other.analysis.delete', ['id' => $analysis->id ]) }}">
            <button class="pm-btn pm-btn-white btn pm-btn-trash">
                <i class="fas fa-trash"></i>
            </button>
        </a>
    @endif
@endsection

@section('content')
    <div class="content-wrapper preview-content-wrapper">
        <div class="form__info">
            <div class="form__info__inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ html()->label(__('Naslov'))->for('title')->class('bold') }}
                            {{ html()->text('title')->class('form-control form-control-sm')->value((isset($analysis) ? $analysis->title : ''))->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Datum početka'))->for('date_from')->class('bold') }}
                            {{ html()->text('date_from')->class('form-control form-control-sm')->required()->value((isset($analysis) ? $analysis->dateFrom() : date('d.m.Y')))->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Datum završetka'))->for('date_to')->class('bold') }}
                            {{ html()->text('date_to')->class('form-control form-control-sm')->required()->value((isset($analysis) ? $analysis->dateTo() : date('d.m.Y')))->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                </div>

                <div class="analysis__description mt-32">
                    {!! nl2br($analysis->description) !!}
                </div>
            </div>
        </div>

        <div class="right__menu__info">
            @include('admin.app.other.analysis.snippets.right-menu')
        </div>
    </div>
@endsection
