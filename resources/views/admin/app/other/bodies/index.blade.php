@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-info-circle"></i> @endsection
@section('c-title') {{ __('Organi i tijela') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.other.bodies') }}">{{ __('Organi i tijela') }}</a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.home') }}">
        <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>
    </a>
    <a href="{{ route('system.admin.other.bodies.create') }}">
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

        @include('admin.layout.snippets.filters.filter-header', ['var' => $bodies])
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
            @foreach($bodies as $body)
                <tr>
                    <td class="text-center">{{ $i++}}</td>
                    <td> {{ $body->title ?? ''}} </td>
                    <td> {{ $body->categoryRel->name ?? ''}} </td>
                    <td> {{ $body->date() ?? ''}} </td>
                    <td> {{ $body->time ?? ''}} </td>
                    <td> {{ $body->participants ?? ''}} </td>

                    <td class="text-center">
                        <a class="table-btn-link" href="{{route('system.admin.other.bodies.preview', ['id' => $body->id] )}}" title="{{ __('Pregled događaja') }}">
                            <button class="table-btn">{{ __('Pregled') }}</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.layout.snippets.filters.pagination', ['var' => $bodies])
    </div>
@endsection
