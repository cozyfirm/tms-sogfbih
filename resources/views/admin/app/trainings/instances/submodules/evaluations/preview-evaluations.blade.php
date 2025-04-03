@extends('admin.layout.layout')
@section('c-icon') <i class="fa-solid fa-user-pen"></i> @endsection
@section('c-title') {{ __('Popunjene evaluacije') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">{{ __('..') }}</a> /
    <a href="{{ route('system.admin.trainings.instances') }}">{{ __('Instance obuka') }}</a> /
    <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}">{{ $instance->trainingRel->title ?? '' }}</a> /
    <a href="{{ route('system.admin.trainings.instances.submodules.evaluations.preview-evaluations', ['instance_id' => $instance->id ]) }}">{{ __('Popunjene evaluacije') }}</a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}" title="{{ __('Nazad na obuku') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        @include('admin.layout.snippets.filters.filter-header', ['var' => $evaluations])
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
            @foreach($evaluations as $evaluation)
                <tr>
                    <td class="text-center">{{ $i++}}</td>
                    <td> {{ $evaluation->userRel->name ?? ''}} </td>
                    <td> {{ $evaluation->created_at ?? ''}} </td>

                    <td class="text-center">
                        <a class="table-btn-link" target="_blank" href="{{ route('system.admin.trainings.instances.submodules.evaluations.preview-evaluation', ['evaluation_id' => $evaluation->evaluation_id, 'user_id' => $evaluation->user_id ]) }}" title="{{ __('Pregled evaluacije') }}">
                            <button class="table-btn">{{ __('Pregled') }}</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.layout.snippets.filters.pagination', ['var' => $evaluations])
    </div>
@endsection
