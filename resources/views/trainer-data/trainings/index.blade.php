@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/training-instance.svg') }}" alt="{{ __('Training-instance image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/training-instance-yellow.svg') }}" alt="{{ __('Training instance image') }}">
@endsection
@section('c-title') {{ $header }} @endsection
@section('c-breadcrumbs')
    <a href="{{ route('system.trainer-data.dashboard') }}"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">{{ $header }}</a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.trainer-data.dashboard') }}">
        <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>
    </a>
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
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
                    <td class="text-center">{{ $i++}}. </td>
                    <td> {{ $instance->trainingRel->title ?? ''}} </td>
                    <td> {{ $instance->applicationDate() ?? ''}} </td>
                    <td>
                        <ul class="mb-0 pl-1">
                            @foreach($instance->applicationsRel as $application)
                                <li>
                                    <a href="{{ route('system.admin.users.preview', ['username' => $application->userRel->username ?? '#']) }}" target="_blank" class="hover-yellow-text">
                                        {{ $application->userRel->name ?? '' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td> {{ $instance->total_applications ?? ''}} </td>

                    <td class="text-center">
                        <a class="table-btn-link" href="{{route('system.trainer-data.trainings.preview', ['id' => $instance->id] )}}" title="{{ __('Pregled obuke') }}">
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
