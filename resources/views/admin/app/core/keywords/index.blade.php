@extends('admin.layout.layout')
@section('c-icon') <i class="fa-solid fa-unlock-keyhole"></i> @endsection
@section('c-title') {{ __('Pregled svih šifarnika') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> / <a href="{{ route('system.admin.core.keywords') }}">{{ __('Šifarnici') }}</a>
@endsection
@section('c-buttons')
    <a href="#">
        <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>
    </a>
    <a href="#">
        <button class="pm-btn btn pm-btn-success">
            <i class="fas fa-plus"></i>
            <span>{{ __('Unos') }}</span>
        </button>
    </a>
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-bs">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th width="80px" class="text-center">{{ __('#') }}</th>
                <th>{{ __('Vrsta šifarnika') }}</th>
                <th width="120px" class="akcije text-center">{{__('Akcije')}}</th>
            </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp
            @foreach($keywords as $key => $val)
                <tr>
                    <td class="text-center">{{ $i++}}</td>
                    <td> {{ $val ?? ''}} </td>

                    <td class="text-center">
                        <a class="table-btn-link" href="{{ route('system.admin.core.keywords.preview-instances', ['key' => $key]) }}" title="{{ __('Više informacija') }}">
                            <button class="table-btn">{{ __('Više info') }}</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
