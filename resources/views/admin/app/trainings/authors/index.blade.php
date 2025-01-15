@extends('admin.layout.layout')
@section('c-icon')
    <i class="fas fa-users"></i>
@endsection
@section('c-title') {{ __('Autori programa obuka') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.trainings.home') }}">{{ __('Sistem obuka') }}</a> /
    <a href="{{ route('system.admin.trainings.authors') }}">{{ __('Autori programa obuka') }}</a>
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

        @include('admin.layout.snippets.filters.filter-header', ['var' => $authors])
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
            @foreach($authors as $author)
                <tr>
                    <td class="text-center">{{ $i++}}.</td>
                    <td> {{ $author->title ?? ''}} </td>
                    <td> {{ $author->typeRel->name ?? ''}} </td>
                    <td> {{ $author->email ?? ''}} </td>
                    <td> {{ $author->address ?? ''}} </td>
                    <td> {{ $author->cityRel->title ?? ''}} </td>
                    <td> {{ $author->phone ?? ''}} </td>
                    <td> {{ $author->cellphone ?? ''}} </td>

                    <td class="text-center">
                        <a class="table-btn-link" href="{{route('system.admin.trainings.authors.preview', ['id' => $author->id] )}}" title="Pregled korisnika">
                            <button class="table-btn">{{ __('Pregled') }}</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.layout.snippets.filters.pagination', ['var' => $authors])
    </div>
@endsection
