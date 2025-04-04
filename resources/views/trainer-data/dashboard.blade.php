@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-home"></i> @endsection
@section('c-title') {{ __('Dashboard') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Upravljačka tabla admin panela') }}</p> </a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.trainer-data.dashboard') }}">
        <button class="pm-btn btn btn-dark"> <i class="fas fa-star"></i> </button>
    </a>
@endsection

@section('content')
    <div class="homepage">
        <div class="homepage-main">
            <div class="home-row home-row-top">
                <div class="home-row-header">
                    <h4> {{__('OSNOVNE INFORMACIJE')}} </h4>
                </div>

                <div class="home-row-body">
                    <div class="home-row-items">
                        <div class="home-icon" title="{{__('Ukupan broj obuka')}}">
                            <h1> {{ $instances ?? '0'}}</h1>
                            <p>{{__('Aktivnih obuka')}}</p>
                        </div>
                        <div class="home-icon" title="{{__('Broj obuka kao trener')}}">
                            <h1>{{ Auth()->user()->trainersRel()->count() }}</h1>
                            <p>{{__('Mojih obuka')}}</p>
                        </div>
                        <div class="home-icon" title="{{__('Prosječna ocjena')}}">
                            <h1>{{ Auth()->user()->averageGrade() }}</h1>
                            <p>{{__('Ocjena')}}</p>
                        </div>
                        <div class="home-icon" title="{{__('Ukupna zarada')}}">
                            <h1>{{ Auth()->user()->contractValue() ?? '0'}}</h1>
                            <p>{{__('Ukupno KM')}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="home-row">
                <div class="home-row-header">
                    <h4> {{__('OSTALO')}} </h4>
                </div>

                <div class="home-row-body">
                    <div class="home-row-items">
                        <div class="home-icon go-to" link="{{ route('system.trainer-data.trainings') }}" title="{{__('Sistem obuka')}}">
                            <img class="normal-icon" src="{{ asset('files/images/icons/training.svg') }}" alt="{{ __('Training image') }}">
                            <img class="white-icon" src="{{ asset('files/images/icons/training-white.svg') }}" alt="{{ __('Training image') }}">
                            <p> {{__('Sistem obuka')}} </p>
                        </div>
                        <div class="home-icon go-to" link="{{ route('system.trainer-data.trainings.my-trainings') }}">
                            <i class="fa-solid fa-users-line"></i>
                            <p> {{__('Moje obuke')}} </p>
                        </div>
                        <div class="home-icon go-to" link="{{ route('system.user-data.my-profile') }}">
                            <i class="fa-solid fa-user"></i>
                            <p> {{__('Moj profil')}} </p>
                        </div>
                        <div class="home-icon go-to new-window" link="/files/instructions/trainer-manual.pdf" title="{{ __('Instrukcije za korištenje sistema') }}">
                            <i class="fa-solid fa-book-open-reader"></i>
                            <p> {{__('Korisničko uputstvo')}} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="homepage-side">
            <div class="reminders home-right-wrapper">
                <div class="home-right-header">
                    <p>{{ __('Posljednje obuke') }}</p>
                </div>
                @php $counter = 0; @endphp
                @foreach(Auth()->user()->trainersRel as $instance)
                    @php if($counter++ > 3) break; @endphp
                    <div class="home-right-element go-to" link="{{ route('system.user-data.trainings.preview', ['id' => $instance->instance_id ]) }}">
                        {{ $instance->createdAt() ?? '' }} - <b><i>"{{ $instance->instanceRel->trainingRel->title ?? '' }}"</i></b>
                    </div>
                @endforeach
            </div>

            <div class="reminders home-right-wrapper">
                <div class="home-right-header">
                    <p> {{__('Brzi linkovi')}} </p>
                </div>

                <div class="home-right-element go-to new-window" link="https://sogfbih.ba">
                    {{__('SOG FBiH')}}
                </div>
            </div>
        </div>
    </div>
@endsection
