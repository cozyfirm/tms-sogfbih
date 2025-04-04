<div class="three__elements">
    <div class="element" title="{{ __('Broj prijava na obuci') }}">
        <h5 class="ud-t-no-of-apps">{{ $instance->applicationsRel->count() }}</h5>
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

@if($instance->applicationsRel->count())
    <div class="rm-card">
        <div class="rm-card-header">
            <h5>{{ __('Posljednje prijave') }}</h5>
            <img class="normal-icon" src="{{ asset('files/images/icons/training-instance.svg') }}" alt="{{ __('Training-instance image') }}">
        </div>
        <hr>
        <div class="list__wrapper">
            <ol>
                @foreach($instance->applicationsRel as $app)
                    <a class="hover-yellow-text" title="{{ __('Ime i prezime polaznika obuke') }}">
                        <li> {{ $app->userRel->name ?? '' }} </li>
                    </a>
                @endforeach
            </ol>
        </div>
    </div>
@endif

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
                        <a href="{{ route('system.trainer-data.download.download-instance-file', ['id' => $file->id ]) }}" title="{{ __('Preuzmite dokument') }}">
                            {{ $counter++ }}. {{ $file->file ?? '' }}
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endif

<div class="rm-card-icons">
    <a href="{{ route('system.trainer-data.trainings.additional-data.photo-gallery', ['instance_id' => $instance->id ]) }}" title="{{ __('Galerija fotografija') }}" class="instance-gallery">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/camera-retro-solid.svg') }}" alt="{{ __('Gallery image') }}">
        </div>
    </a>
</div>
