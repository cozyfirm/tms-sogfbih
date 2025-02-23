@extends('admin.layout.layout')
@section('c-icon') <i class="fa-solid fa-map"></i> @endsection
@section('c-title') {{ __('Lokacije') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.trainings.home') }}">{{ __('Sistem obuka') }}</a> /
    <a href="{{ route('system.admin.trainings.submodules.evaluations') }}">{{ __('Pregled svih evaluacija') }}</a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.admin.trainings.home') }}">
        <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>
    </a>
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

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
            @foreach($evaluations as $location)
                <tr>
                    <td class="text-center">{{ $i++}}</td>
                    <td> {{ $location->modelRel->title ?? ''}} </td>
                    <td> {{ $location->lockedRel->name ?? ''}} </td>
                    <td> {{ $location->submissions ?? ''}} </td>

                    <td class="text-center">
                        <a class="table-btn-link" href="#" title="{{ __('Pregled evaluacije') }}">
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
