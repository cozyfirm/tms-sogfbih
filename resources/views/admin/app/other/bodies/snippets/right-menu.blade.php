<div class="three__elements">
    <div class="element" title="{{ __('Datum i vrijeme održavanja') }}">
        <h5>{{ $body->time ?? '08:00' }}</h5>
        <p>{{ (isset($body) ? $body->date() : date('d.m.Y')) }}</p>
    </div>
    <div class="element" title="{{ __('Broj unesenih zaključaka sa događaja') }}">
        <h5 class="total-participants">{{ $body->participantsRel->count() }}</h5>
        <p>{{ __('Učesnika') }}</p>
    </div>
    <div class="element" title="{{ __('Broj priloženih dokumenata') }}">
        <h5>{{ FileHelper::getBodyFiles($body->id)->count() }}</h5>
        <p>{{ __('Dokumenata') }}</p>
    </div>
</div>

<div class="rm-card" title="{{ __('Mjesto održavanja događaja') }}">
    <div class="rm-card-header">
        <h5>{{ $body->locationRel->title ?? 'Nepoznata lokacija' }}</h5>
        <i class="fa-solid fa-map"></i>
    </div>
    <hr>
    <div class="location__wrapper">
        <div class="lw__row">
            <i class="fa-solid fa-location-dot"></i>
            <p>{{ $body->locationRel->address ?? '' }}, {{ $body->locationRel->cityRel->title ?? '' }}</p>
        </div>
        <div class="lw__row">
            <i class="fa-solid fa-envelope"></i>
            <p>{{ $body->locationRel->email ?? '' }}</p>
        </div>
        <div class="lw__row">
            <i class="fa-solid fa-phone-volume"></i>
            <p>{{ $body->locationRel->phone ?? '' }}</p>
        </div>
    </div>
</div>

@if(FileHelper::getBodyFiles($body->id)->count())
    <div class="rm-card">
        <div class="rm-card-header">
            <h5>{{ __('Priloženi dokumenti') }}</h5>
            <img class="normal-icon" src="{{ asset('files/images/icons/folder-open-regular.svg') }}" alt="{{ __('Training-instance image') }}">
        </div>

        <!-- Uploaded files to training instance -->
        @if(FileHelper::getBodyFiles($body->id)->count())
            <hr>
            <div class="list__wrapper list__wrapper__flex">
                @php $counter = 1; @endphp
                @foreach(FileHelper::getBodyFiles($body->id) as $file)
                    <div class="document__row">
                        <a href="{{ route('system.admin.other.bodies.download-file', ['id' => $file->id ]) }}" title="{{ __('Preuzmite dokument') }}">
                            {{ $counter++ }}. {{ $file->file ?? '' }}
                        </a>

                        <div class="remove__icon" title="{{ __('Obrišite dokument') }}">
                            <a href="{{ route('system.admin.other.bodies.remove-file', ['id' => $file->id]) }}">
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
    <a title="{{ __('Dodajte učesnike') }}" class="bodies-add-participant">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/users.svg') }}" alt="{{ __('Trainer image') }}">
        </div>
    </a>
    <a title="{{ __('Upload dokumenata') }}" class="upload-files">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/cloud-arrow-up-solid.svg') }}" alt="{{ __('Upload file') }}">
        </div>
    </a>
    <a href="{{ route('system.admin.other.bodies.gallery', ['id' => $body->id ]) }}" title="{{ __('Galerija fotografija') }}" class="instance-gallery">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/camera-retro-solid.svg') }}" alt="{{ __('Gallery image') }}">
        </div>
    </a>
</div>
