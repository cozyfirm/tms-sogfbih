@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-users"></i> @endsection
@section('c-title') {{ __('Prijave na obuku') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">{{ __('..') }}</a> /
    <a href="{{ route('system.admin.trainings.instances') }}">{{ __('Instance obuka') }}</a> /
    <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}">{{ $instance->trainingRel->title ?? '' }}</a> /
    <a href="#">{{ __('Prijave na obuku') }}</a>
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
        @include('admin.layout.snippets.filters.filter-header', ['var' => $applications])
        <table class="table table-bordered" id="filtering">
            <thead>
            <tr>
                <th scope="col" style="text-align:center;">#</th>
                @include('admin.layout.snippets.filters.filters_header')
            </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp
            @foreach($applications as $application)
                <tr>
                    <td class="text-center">{{ $i++}}. </td>
                    <td>
                        <a class="hover-yellow-text" href="{{route('system.admin.users.preview', ['username' => $application->userRel->username ?? ''] )}}" target="_blank">
                            {{ $application->userRel->name ?? ''}}
                        </a>
                    </td>
                    <td width="160px"> {{ $application->date() ?? ''}} </td>
                    <td width="160px">
                        {{ html()->select('app_status', $statuses, $application->status ?? '1')->class('form-control form-control-sm app_status__change')->id($application->id) }}
                    </td>
                    <td>
                        @if($application->presence)
                            <a class="hover-yellow-text" href="{{ route('system.admin.trainings.instances.submodules.applications.download-certificate', ['id' => $application->id ]) }}">
                                {{ __('Preuzmite certifikat') }}
                            </a>
                        @else
                            {{ __('Nije dostupno') }}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.layout.snippets.filters.pagination', ['var' => $applications])
    </div>
@endsection
