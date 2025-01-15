@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-key"></i> @endsection
@section('c-title') {{ __('Pregled svih šifarnika') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.core.keywords') }}">{{ __('Šifarnici') }}</a> /
    <a href="#">{{ __('Pregled instanci') }}</a>
@endsection
@section('c-buttons')
    <a href="#">
        <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>
    </a>
    <a href="{{ route('system.admin.core.keywords.new-instance', ['key' => $key]) }}">
        <button class="pm-btn btn pm-btn-success">
            <i class="fas fa-plus"></i>
            <span>{{ __('Unos') }}</span>
        </button>
    </a>
@endsection


@section('content')
    <div class="content-wrapper content-wrapper-bs">
        @if(session()->has('success'))
            <div class="alert alert-success mt-3">
                {{ session()->get('success') }}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger mt-3">
                {{ session()->get('error') }}
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
                    <td> {{ $instance->name ?? ''}} </td>
                    <td> {{ $instance->description ?? ''}} </td>
                    <td class="text-center" width="180px"> {{ $instance->value ?? ''}} </td>

                    <td class="text-center">
                        <a class="table-btn-link" href="{{ route('system.admin.core.keywords.edit-instance', ['id' => $instance->id ]) }}" title="Pregled instance šifarnika">
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
