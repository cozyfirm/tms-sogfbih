@if(Auth()->user()->role == 'trainer')
    <div class="three__elements">
        <div class="element">
            <h5>{{ $user->trainersRel->count() }}</h5>
            <p>{{ __('Ukupno obuka') }}</p>
        </div>
        <div class="element" title="{{ __('Prosječna ocjena') }}">
            <h5>{{ $user->averageGrade() }}</h5>
            <p>{{ __('Ocjena') }}</p>
        </div>
        <div class="element">
            <h5> {{ $user->contractValue() }} </h5>
            <p>{{ __('Ukupno KM') }}</p>
        </div>
    </div>
@else
    <div class="three__elements">
        <div class="element">
            <h5>{{ Auth()->user()->totalTrainings() }}</h5>
            <p>{{ __('Mojih obuka') }}</p>
        </div>
        <div class="element">
            <h5>{{ Auth()->user()->totalCertificates() }}</h5>
            <p>{{ __('Certifikata') }}</p>
        </div>
        <div class="element">
            <h5>{{ Auth()->user()->userDaysOfTraining() ?? '0'}}</h5>
            <p>{{ __('Dana predavanja') }}</p>
        </div>
    </div>
@endif

@if(Auth()->user()->educationsRel->count())
    @foreach(Auth()->user()->educationsRel as $education)
        <div class="rm-card" title="{{ __('Informacije o edukaciji') }}">
            <div class="rm-card-header">
                <div class="text__part" title="{{ __('Fakultet i univerzitet') }}">
                    <h5><a href="{{ route('system.user-data.my-profile.education.edit-education', ['id' => $education->id ]) }}" class="hover-yellow-text" title="{{ __('Uredite informacije') }}">{{ $education->school ?? '' }}</a></h5>
                    <p>{{ $education->university ?? '' }}</p>
                </div>
                <i class="fa-solid fa-building-columns"></i>
            </div>
            <hr>
            <div class="location__wrapper">
                <div class="lw__row" title="{{ __('Stečeno zvanje') }}">
                    <i class="fa-solid fa-user-graduate"></i>
                    <p>{{ $education->title ?? '' }}, {{ $education->levelRel->name ?? '' }}</p>
                </div>
                <div class="lw__row" title="{{ __('Datum diplomiranja') }}">
                    <i class="fa-solid fa-calendar-day"></i>
                    <p>{{ $education->date() ?? '' }}</p>
                </div>
            </div>
        </div>
    @endforeach
@endif

@if(Auth()->user()->myLastTrainings->count())
    <div class="rm-card">
        <div class="rm-card-header" title="{{ __('Moje posljednje obuke') }}">
            <h5>{{ __('Posljednje obuke') }}</h5>
            <img class="normal-icon" src="{{ asset('files/images/icons/training.svg') }}" alt="{{ __('Training image') }}">
        </div>
        <hr>
        <div class="list__wrapper">
            <ol>
                @foreach(Auth()->user()->myLastTrainings as $training)
                    <li>
                        <a href="{{ route('system.user-data.trainings.preview', ['id' => $training->instance_id ]) }}">
                            {{ $training->instanceRel->trainingRel->title ?? '' }}
                        </a>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
@endif

<div class="rm-card-icons">
    <a href="{{ route('system.user-data.my-profile.education.create-education') }}" title="{{ __('Stručna sprema') }}" class="open-add-author">
        <div class="rm-ci-w">
            <img class="normal-icon" src="{{ asset('files/images/icons/building-columns-solid.svg') }}" alt="{{ __('University image') }}">
        </div>
    </a>

    @if(Auth()->user()->role == 'trainer')
        <a href="{{ route('system.user-data.my-profile.areas.edit') }}" title="">
            <div class="rm-ci-w">
                <img src="{{ asset('files/images/icons/category.svg') }}" alt="{{ __('Area image') }}">
            </div>
        </a>
    @endif
{{--    <a href="{{ route('system.user-data.trainings') }}" title="{{ __('Sistem obuka') }}">--}}
{{--        <div class="rm-ci-w">--}}
{{--            <img class="normal-icon" src="{{ asset('files/images/icons/training.svg') }}" alt="{{ __('Training image') }}">--}}
{{--        </div>--}}
{{--    </a>--}}
</div>

<!-- System access -->
@if(Auth()->user()->systemAccessRel->count())
    <div class="rm-card" title="{{ __('Korisnički podaci') }}">
        <div class="rm-card-header">
            <div class="text__part">
                <h5>{{ __('Pristup sistemu') }}</h5>
            </div>
            <i class="fa-solid fa-laptop-file"></i>
        </div>
        <hr>
        <div class="system__access">
            @foreach(Auth()->user()->systemAccessRel as $access)
                <div class="sa__row">
                    <p> {{ $access->dateTime() }} {{ $access->description ?? '' }}</p>
                    @if($access->action == 'sign-in')
                        <i class="fa-solid fa-right-to-bracket"></i>
                    @else
                        <i class="fa-solid fa-power-off"></i>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif
