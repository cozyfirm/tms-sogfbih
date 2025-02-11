@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/training-instance.svg') }}" alt="{{ __('Training-instance image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/training-instance-yellow.svg') }}" alt="{{ __('Training instance image') }}">
@endsection
@section('c-title') {{ __('Instance obuka') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.trainings.home') }}">{{ __('Sistem obuka') }}</a> /
    <a href="{{ route('system.admin.trainings.instances') }}">{{ __('Instance obuka') }}</a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.admin.trainings.home') }}">
        <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>
    </a>
    <a href="{{ route('system.admin.trainings.instances.create') }}">
        <button class="pm-btn btn pm-btn-success">
            <i class="fas fa-plus"></i>
            <span>{{ __('Unos') }}</span>
        </button>
    </a>
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        @include('admin.layout.snippets.filters.filter-header', ['var' => $instances])
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
            @foreach($instances as $instance)
                <tr>
                    <td class="text-center">{{ $i++}}</td>
                    <td> {{ $instance->trainingRel->title ?? ''}} </td>
                    <td> {{ $instance->applicationDate() ?? ''}} </td>
                    <td> {{ $instance->contract ?? ''}} </td>
                    <td>
                        {{ $instance->reportRel->name ?? '' }}
                        @if($instance->report)
                            (<a class="hover-yellow-text" title="{{ __('Preuzmite izvještaj') }}" href="{{ route('system.admin.trainings.instances.submodules.reports.download-report', ['instance_id' => $instance->id ]) }}">{{ $instance->reportFileRel->file ?? '' }}</a>)
                        @endif
                    </td>

                    <td class="text-center">
                        <a class="table-btn-link" href="{{route('system.admin.trainings.instances.preview', ['id' => $instance->id] )}}" title="{{ __('Pregled obuke') }}">
                            <button class="table-btn">{{ __('Pregled') }}</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.layout.snippets.filters.pagination', ['var' => $instances])
    </div>
@endsection
