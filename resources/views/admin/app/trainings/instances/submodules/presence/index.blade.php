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
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col" style="text-align:center;">#</th>
                <th scope="col">{{ __('Ime i prezime') }}</th>
                @foreach($dates as $date)
                    <th scope="col" style="text-align:center;">{{ $date->date() }}</th>
                @endforeach
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
                    @foreach($dates as $date)
                        <th scope="col" style="text-align:center;">
                            <input type="checkbox" class="presence-check" name="presence[]" id="{{ $application->id }}" date="{{ $date->date }}" @if(ApplicationHelper::isPresent($application->id, $date->date)) checked @endif>
                        </th>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
