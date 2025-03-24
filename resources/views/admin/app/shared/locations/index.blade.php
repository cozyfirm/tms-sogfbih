@extends('admin.layout.layout')
@section('c-icon') <i class="fa-solid fa-map"></i> @endsection
@section('c-title') {{ __('Lokacije') }} @endsection
@section('c-breadcrumbs')
    <a href="{{ route('system.home') }}"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.shared.locations') }}">{{ __('Pregled svih lokacija') }}</a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.home') }}">
        <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>
    </a>
    <a href="{{ route('system.admin.shared.locations.create') }}">
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

        @include('admin.layout.snippets.filters.filter-header', ['var' => $locations])
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
            @foreach($locations as $location)
                <tr>
                    <td class="text-center">{{ $i++}}</td>
                    <td> {{ $location->title ?? ''}} </td>
                    <td> {{ $location->address ?? ''}} </td>
                    <td> {{ $location->cityRel->title ?? ''}} </td>
                    <td> {{ $location->cityRel->countryRel->name_ba ?? ''}} </td>
                    <td> {{ $location->phone ?? ''}} </td>
                    <td> {{ $location->email ?? ''}} </td>

                    <td class="text-center">
                        <a class="table-btn-link" href="{{route('system.admin.shared.locations.preview', ['id' => $location->id] )}}" title="{{ __('Pregled lokacije') }}">
                            <button class="table-btn">{{ __('Pregled') }}</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.layout.snippets.filters.pagination', ['var' => $locations])
    </div>
@endsection
