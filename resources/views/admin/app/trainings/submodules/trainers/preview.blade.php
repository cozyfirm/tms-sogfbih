@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/trainer.svg') }}" alt="{{ __('Training image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/trainer-yellow.svg') }}" alt="{{ __('Training image') }}">
@endsection
@section('c-title') {{ $user->name }} @endsection
@section('c-breadcrumbs')
    <a href="{{ route('system.home') }}"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.trainings.home') }}">{{ __('Sistem obuka') }}</a> /
    <a href="{{ route('system.admin.trainings.submodules.trainers') }}">{{ __('Pregled svih trenera') }}</a> /
    <a href="{{ route('system.admin.users.preview', ['username' => $user->username ]) }}">{{ $user->name }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.trainings.submodules.trainers') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @if(isset($preview))
        <a href="{{ route('system.admin.users.edit', ['username' => $user->username ]) }}" target="_blank">
            <button class="pm-btn btn pm-btn-edit">
                <i class="fas fa-edit"></i>
            </button>
        </a>
    @endif
@endsection

@section('content')
    <!-- Fetch trainer info -->
    @include('admin.app.trainings.submodules.trainers.includes.fetch-info')

    <div class="content-wrapper preview-content-wrapper">
        <div class="form__info">
            <div class="form__info__inner">
                <form action="#" method="POST" id="js-form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Ime i prezime'))->for('first_name')->class('bold') }}
                                {{ html()->text('name', $user->name ?? '' )->class('form-control form-control-sm')->required()->value((isset($user) ? $user->name : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Email'))->for('email')->class('bold') }}
                                {{ html()->text('email')->class('form-control form-control-sm')->required()->maxlength(150)->value((isset($user) ? $user->email : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Spol'))->for('gender')->class('bold') }}
                                {{ html()->text('gender')->class('form-control form-control-sm mt-1')->required()->maxlength(100)->value((isset($user->genderRel) ? $user->genderRel->name : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Broj telefona'))->for('phone')->class('bold') }}
                                {{ html()->text('phone')->class('form-control form-control-sm mt-1')->required()->maxlength(13)->value((isset($user) ? $user->phone : '+387'))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Datum rođenja'))->for('birth_date')->class('bold') }}
                                {{ html()->text('birth_date')->class(isset($preview) ? 'form-control form-control-sm mt-1' : 'form-control form-control-sm datepicker mt-1')->required()->maxlength(10)->value((isset($user) ? $user->birthDate() : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Adresa'))->for('address')->class('bold') }}
                                {{ html()->text('address')->class('form-control form-control-sm mt-1')->required()->maxlength(100)->value((isset($user) ? $user->address : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Grad'))->for('city')->class('bold') }}
                                {{ html()->text('city')->class('form-control form-control-sm mt-1')->required()->maxlength(100)->value((isset($user->cityRel) ? $user->cityRel->title : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Radno mjesto'))->for('workplace')->class('bold') }}
                                {{ html()->text('workplace')->class('form-control form-control-sm mt-1')->required()->maxlength(100)->value((isset($user) ? $user->workplace : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Institucija'))->for('institution')->class('bold') }}
                                {{ html()->text('institution')->class('form-control form-control-sm mt-1')->required()->maxlength(100)->value((isset($user->institutionRel) ? $user->institutionRel->name : ''))->isReadonly(isset($preview)) }}
                            </div>
                        </div>
                    </div>
                </form>

                @if(isset($preview) and $user->areaRel->count())
                    <div class="custom-hr"></div>

                    <div class="mp__areas mb-32">
                        <h4>{{ __('Oblasti ekspertize') }}</h4>
                        <div class="mp__area__inner">
                            @foreach($user->areaRel as $area)
                                <div class="area__w">
                                    <p>{{ $area->areaRel->name ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($user->trainersRel->count())
                    <div class="custom-hr"></div>

                    <div class="trainers__inner_w">
                        <div class="iiw__header" title="{{ __('Obuke na kojima je trener prisustvovao') }}">
                            <p>{{ __('Pregled obuka') }}</p>
                            <a>
                                <img src="{{ asset('files/images/icons/training-instance-white.svg') }}" alt="{{ __('Training-instance image') }}">
                            </a>
                        </div>
                        <table class="table table-bordered mt-3">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center" width="40px">#</th>
                                <th scope="col">{{ __('Program') }}</th>
                                <th scope="col">{{ __('Datum') }}</th>
                                <th scope="col">{{ __('Ocjena') }}</th>
                                <th scope="col">{{ __('Vrijednost') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $counter = 1; @endphp
                            @foreach($trainings as $trainer)
                                <tr>
                                    <th scope="row" class="text-center">{{ $counter++ }}.</th>
                                    <td class="hover-yellow-text fetch-trainer-info" id="{{ $trainer->id }}" title="{{ __('Više informacija') }}">
                                        {{ $trainer->instanceRel->trainingRel->title ?? '' }}
                                    </td>
                                    <td> {{ $trainer->instanceRel->startDate() ?? '' }} </td>
                                    <td>{{ $trainer->grade }}</td>
                                    <td>{{ $trainer->contract ?? '' }}KM</td>
                                </tr>
                            @endforeach

                            <tr>
                                <th colspan="3" class="text-end">{{ __('UKUPNO') }}</th>
                                <td><b>{{ $user->averageGrade() }}</b></td>
                                <td><b>{{ $user->contractValue() }}KM</b></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="right__menu__info">
            @include('admin.app.trainings.submodules.trainers.snippets.right-menu')
        </div>
    </div>
@endsection
