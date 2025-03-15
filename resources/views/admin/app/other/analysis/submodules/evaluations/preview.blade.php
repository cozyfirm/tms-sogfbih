@extends('admin.layout.layout')
@section('c-icon')
    <i class="fa-solid fa-user-pen"></i>
@endsection
@section('c-title') {{ __('Analize potreba za obukama') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">{{ __('..') }}</a> /
    <a href="{{ route('system.admin.other.analysis') }}">{{ __('Analiza potreba za obukama') }}</a>
    <a href="#">{{ $analysis->title ?? '' }}</a> /
    <a href="#">{{ __('Ankete') }}</a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.admin.other.analysis.preview', ['id' => $analysis->id ]) }}" title="{{ __('Nazad na obuku') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>
    @if(!$evaluation->locked)
        <a href="{{ route('system.admin.other.analysis.submodules.evaluations.add-option', ['analysis_id' => $analysis->id ]) }}" title="{{ __('Unos pitanja za evaluaciju') }}">
            <button class="pm-btn btn pm-btn-success">
                <i class="fas fa-plus"></i>
                <span>{{ __('Unos') }}</span>
            </button>
        </a>
        <a href="{{ route('system.admin.other.analysis.submodules.evaluations.lock', ['analysis_id' => $analysis->id ]) }}" title="{{ __('Zaključajte evaluaciju za uređivanje') }}">
            <button class="pm-btn btn pm-btn-trash">
                <i class="fas fa-lock"></i>
                <span>{{ __('Zaključaj') }}</span>
            </button>
        </a>
    @endif
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        @include('admin.layout.snippets.filters.filter-header', ['var' => $options])
        <table class="table table-bordered" id="filtering">
            <thead>
            <tr>
                <th scope="col" style="text-align:center;">#</th>
                @include('admin.layout.snippets.filters.filters_header')
                <th width="120p" class="akcije text-center">{{__('Akcije')}}</th>
            </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp
            @foreach($options as $option)
                <tr>
                    <td class="text-center">{{ $i++}}</td>
                    <td> {{ $option->groupRel->name ?? ''}} </td>
                    <td> {{ $option->typeRel->name ?? ''}} </td>
                    <td> {{ $option->question ?? ''}} </td>
                    <td> {{ $option->description ?? ''}} </td>

                    <td class="text-center">
                        <a class="table-btn-link" href="{{ route('system.admin.other.analysis.submodules.evaluations.preview-option', ['id' => $option->id ]) }}" title="{{ __('Pregled obuke') }}">
                            <button class="table-btn">{{ __('Pregled') }}</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.layout.snippets.filters.pagination', ['var' => $options])
    </div>
@endsection
