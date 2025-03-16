@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/trainer.svg') }}" alt="{{ __('Training image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/trainer-yellow.svg') }}" alt="{{ __('Training image') }}">
@endsection
@section('c-title') {{ __('Treneri') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.trainings.home') }}">{{ __('Sistem obuka') }}</a> /
    <a href="{{ route('system.admin.trainings.submodules.trainers') }}">{{ __('Pregled svih trenera') }}</a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.home') }}">
        <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>
    </a>
    <a href="{{ route('system.admin.users.create') }}">
        <button class="pm-btn btn pm-btn-success">
            <i class="fas fa-plus"></i>
            <span>{{ __('Unos novog') }}</span>
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

        @include('admin.layout.snippets.filters.filter-header', ['var' => $users])
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
            @foreach($users as $user)
                <tr>
                    <td class="text-center">{{ $i++}}</td>
                    <td> {{ $user->name ?? ''}} </td>
                    <td> {{ $user->email ?? ''}} </td>
                    <td> {{ ucfirst($user->role ?? '')  }} </td>
                    <td> {{ $user->phone ?? ''}} </td>
                    <td> {{ $user->birthDate() ?? ''}} </td>
                    <td>
                        <ul class="m-0 pl-2">
                            @foreach($user->trainersRel as $trainer)
                                <li> {{ $trainer->instanceRel->trainingRel->title ?? '' }} </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul class="m-0 pl-2">
                            @foreach($user->trainersRel as $trainer)
                                <li> {{ $trainer->grade ?? '' }} </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul class="m-0 pl-2">
                            @foreach($user->trainersRel as $trainer)
                                <li> {{ $trainer->contract ?? '' }} KM </li>
                            @endforeach
                        </ul>
                    </td>

                    <td> {{ $user->address ?? ''}} </td>
                    <td> {{ $user->city ?? ''}} </td>
                    <td> {{ $user->countryRel->name_ba ?? ''}} </td>

                    <td class="text-center">
                        <a class="table-btn-link" href="{{route('system.admin.users.preview', ['username' => $user->username] )}}" title="{{ __('Pregled korisnika') }}">
                            <button class="table-btn">{{ __('Pregled') }}</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.layout.snippets.filters.pagination', ['var' => $users])
    </div>
@endsection
