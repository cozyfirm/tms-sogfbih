<div class="three__elements">
    <div class="element" title="{{ __('Broj prijava na obuci') }}">
        <h5>{{ $instance->applicationsRel->count() }}</h5>
        <p>Prijava</p>
    </div>
    <div class="element" title="{{ __('Broj polaznika na obuci') }}">
        <h5>{{ $instance->trainersRel->count() }}</h5>
        <p>Trenera</p>
    </div>
    <div class="element" title="{{ __('Trajanje obuke') }}">
        <h5>{{ $instance->totalDays() }}</h5>
        <p>Dana</p>
    </div>
</div>

<div class="rm-card rm-sign-up" instance-id="{{ $instance->id }}">
    <div class="rm-card-header jc-start rm-sign-up-inner">
        @if(Auth()->user()->isSigned($instance->id))
            <h5>{{ __('Odjavite se sa obuke') }}</h5>
        @else
            <h5>{{ __('Prijavite se na obuku') }}</h5>
            <i class="fa-solid fa-arrow-right-long"></i>
        @endif
    </div>
</div>

@if(FileHelper::getPublicInstanceFiles($instance->id)->count())
    <div class="rm-card">
        <div class="rm-card-header">
            <h5>{{ __('Priloženi dokumenti') }}</h5>
            <img class="normal-icon" src="{{ asset('files/images/icons/folder-open-regular.svg') }}" alt="{{ __('Training-instance image') }}">
        </div>

        <!-- Uploaded files to training instance -->
        @if(FileHelper::getPublicInstanceFiles($instance->id)->count())
            <hr>
            <div class="list__wrapper list__wrapper__flex">
                @php $counter = 1; @endphp
                @foreach(FileHelper::getPublicInstanceFiles($instance->id) as $file)
                    <div class="document__row">
                        <a href="{{ route('system.user-data.download.download-instance-file', ['id' => $file->id ]) }}" title="{{ __('Preuzmite dokument') }}">
                            {{ $counter++ }}. {{ $file->file ?? '' }}
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endif

<div class="rm-card-icons">
    <a title="{{ __('Agenda obuke') }}">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/calendar-plus-solid.svg') }}" alt="{{ __('Calendar image') }}">
        </div>
    </a>
    <a href="#" title="{{ __('Evaluacija obuke') }}">
        <div class="rm-ci-w">
            <i class="fa-solid fa-user-pen"></i>
        </div>
    </a>
    <a href="{{ route('system.user-data.trainings.additional-data.photo-gallery', ['instance_id' => $instance->id ]) }}" title="{{ __('Galerija fotografija') }}" class="instance-gallery">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/camera-retro-solid.svg') }}" alt="{{ __('Gallery image') }}">
        </div>
    </a>
    @isset($application)
        @if($application->presence)
            <a href="{{ route('system.user-data.trainings.apis.applications.download-certificate', ['application_id' => $application->id]) }}" title="{{ __('Preuzmite vaš certifikat') }}">
                <div class="rm-ci-w">
                    <i class="fa-solid fa-certificate"></i>
                </div>
            </a>
        @endif
    @endisset
</div>
