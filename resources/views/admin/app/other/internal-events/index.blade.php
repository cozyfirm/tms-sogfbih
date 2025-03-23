@extends('admin.layout.layout')
@section('c-icon') <i class="fa-solid fa-calendar-days"></i> @endsection
@section('c-title') {{ __('Interni događaji saveza') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.other.internal-events') }}">{{ __('Interni događaji') }}</a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.home') }}">
        <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>
    </a>
    <a href="{{ route('system.admin.other.internal-events.create') }}">
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

        @include('admin.layout.snippets.filters.filter-header', ['var' => $events])
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
            @foreach($events as $event)
                <tr>
                    <td class="text-center">{{ $i++}}</td>
                    <td> {{ $event->title ?? ''}} </td>
                    <td> {{ $event->categoryRel->name ?? ''}} </td>
                    <td> {{ $event->projectRel->name ?? ''}} </td>
                    <td> {{ $event->date() ?? ''}} </td>
                    <td> {{ $event->time ?? ''}} </td>
                    <td> {{ $event->participants ?? ''}} </td>

                    <td class="text-center">
                        <a class="table-btn-link" href="{{route('system.admin.other.internal-events.preview', ['id' => $event->id] )}}" title="{{ __('Pregled događaja') }}">
                            <button class="table-btn">{{ __('Pregled') }}</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.layout.snippets.filters.pagination', ['var' => $events])
    </div>
@endsection
