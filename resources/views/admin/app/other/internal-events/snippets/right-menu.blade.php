<div class="three__elements">
    <div class="element" title="{{ __('Broj učesnika') }}">
        <h5>{{ __('12') }}</h5>
        <p>{{ __('Učesnika') }}</p>
    </div>
    <div class="element" title="{{ __('Broj unesenih zaključaka sa događaja') }}">
        <h5>0</h5>
        <p>{{ __('Zaključaka') }}</p>
    </div>
    <div class="element" title="{{ __('Broj priloženih dokumenata') }}">
        <h5>{{ FileHelper::getIEFiles($event->id)->count() }}</h5>
        <p>{{ __('Dokumenata') }}</p>
    </div>
</div>

<div class="rm-card">
    <div class="rm-card-header">
        <h5>{{ __('Zaključci') }}</h5>
        <img class="normal-icon" src="{{ asset('files/images/icons/training-instance.svg') }}" alt="{{ __('Training-instance image') }}">
    </div>
    <hr>
    <div class="list__wrapper">
        <ol>
            @for($i=0; $i<3; $i++)
                <li> Sve Elham </li>
            @endfor
        </ol>
    </div>
</div>

@if(FileHelper::getIEFiles($event->id)->count())
    <div class="rm-card">
        <div class="rm-card-header">
            <h5>{{ __('Priloženi dokumenti') }}</h5>
            <img class="normal-icon" src="{{ asset('files/images/icons/folder-open-regular.svg') }}" alt="{{ __('Training-instance image') }}">
        </div>

        <!-- Uploaded files to training instance -->
        @if(FileHelper::getIEFiles($event->id)->count())
            <hr>
            <div class="list__wrapper list__wrapper__flex">
                @php $counter = 1; @endphp
                @foreach(FileHelper::getIEFiles($event->id) as $file)
                    <div class="document__row">
                        <a href="{{ route('system.admin.other.internal-events.download-file', ['id' => $file->id ]) }}" title="{{ __('Preuzmite dokument') }}">
                            {{ $counter++ }}. {{ $file->file ?? '' }}
                        </a>

                        <div class="remove__icon" title="{{ __('Obrišite dokument') }}">
                            <a href="{{ route('system.admin.trainings.instances.remove-file', ['id' => $file->id]) }}">
                                <img src="{{ asset('files/images/icons/trash-can-solid.svg') }}" alt="{{ __('Trash can') }}">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endif

<div class="rm-card-icons">
    <a title="{{ __('Dodajte učesnike') }}" class="instances-add-trainer">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/users.svg') }}" alt="{{ __('Trainer image') }}">
        </div>
    </a>
    <a title="{{ __('Upload dokumenata') }}" class="upload-files">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/cloud-arrow-up-solid.svg') }}" alt="{{ __('Upload file') }}">
        </div>
    </a>
    <a href="#" title="{{ __('Galerija fotografija') }}" class="instance-gallery">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/camera-retro-solid.svg') }}" alt="{{ __('Gallery image') }}">
        </div>
    </a>
</div>
