<div class="three__elements">
    <div class="element go-to" link="{{ route('system.admin.trainings.instances.submodules.applications', ['instance_id' => $instance->id ]) }}" title="{{ __('Broj prijava na obuci') }}">
        <h5>{{ $instance->applicationsRel->count() }}</h5>
        <p>{{ __('Prijava') }}</p>
    </div>
    <div class="element go-to" link="{{ route('system.admin.trainings.instances.submodules.evaluations.preview-evaluations', ['instance_id' => $instance->id ]) }}" title="{{ __('Popunjene evaluacije od strane polaznika') }}">
        <h5>{{ isset($instance->evaluationRel->statusesRel) ? $instance->evaluationRel->statusesRel->count() : '0' }}</h5>
        <p>{{ __('Evaluacija') }}</p>
    </div>
    <div class="element go-to" link="{{ route('system.admin.trainings.instances.submodules.presence', ['instance_id' => $instance->id ]) }}" title="{{ __('Trajanje obuke') }}">
        <h5>{{ $instance->totalDays() }}</h5>
        <p>{{ __('Dana') }}</p>
    </div>
</div>

<div class="rm-card-icons">
    <a title="{{ __('Dodajte trenera na obuku') }}" class="instances-add-trainer">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/trainer.svg') }}" alt="{{ __('Trainer image') }}">
        </div>
    </a>
    <a title="{{ __('Agenda obuke') }}" class="add-event">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/calendar-plus-solid.svg') }}" alt="{{ __('Calendar image') }}">
        </div>
    </a>
    <a href="{{ route('system.admin.trainings.instances.submodules.reports.edit-report', ['instance_id' => $instance->id ]) }}" title="{{ __('Izvještaj o provedenoj obuci') }}">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/book-bookmark-solid.svg') }}" alt="{{ __('Report image') }}">
        </div>
    </a>
    <a href="{{ route('system.admin.trainings.instances.submodules.evaluations.preview', ['instance_id' => $instance->id ]) }}" title="{{ __('Pitanja za evaluaciju') }}">
        <div class="rm-ci-w">
            <i class="fa-solid fa-user-pen"></i>
        </div>
    </a>
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
                    <a href="{{ route('system.admin.users.preview', ['username' => $app->userRel->username ?? 'john-doe']) }}" class="hover-yellow-text" target="_blank" title="{{ __('Više informacija') }}">
                        <li> {{ $app->userRel->name ?? '' }} </li>
                    </a>
                @endforeach
            </ol>
        </div>
    </div>
@endif

@if(FileHelper::getInstanceFiles($instance->id)->count() or $instance->report)
    <div class="rm-card">
        <div class="rm-card-header">
            <h5>{{ __('Priloženi dokumenti') }}</h5>
            <img class="normal-icon" src="{{ asset('files/images/icons/folder-open-regular.svg') }}" alt="{{ __('Training-instance image') }}">
        </div>

        <!-- Uploaded files to training instance -->
        @if(FileHelper::getInstanceFiles($instance->id)->count())
            <hr>
            <div class="list__wrapper list__wrapper__flex">
                @php $counter = 1; @endphp
                @foreach(FileHelper::getInstanceFiles($instance->id) as $file)
                    <div class="document__row">
                        <a href="{{ route('system.admin.trainings.instances.download-file', ['id' => $file->id ]) }}" title="{{ __('Preuzmite dokument') }}">
                            {{ $counter++ }}. {{ $file->file ?? '' }}
                        </a>

                        <div class="remove__icon" title="{{ __('Obrišite dokument') }}">
                            @if($file->instanceRel->visibility == 'public')
                                <img class="visibility" src="{{ asset('files/images/icons/eye-solid.svg') }}" alt="{{ __('Publicly visible') }}" title="{{ __('Dokument je javno dostupan') }}">
                            @else
                                <img class="visibility" src="{{ asset('files/images/icons/eye-slash-solid.svg') }}" alt="{{ __('Privately visible') }}" title="{{ __('Dokument je dostupan samo organizatorima obuke') }}">
                            @endif

                            <a href="{{ route('system.admin.trainings.instances.remove-file', ['id' => $file->id]) }}">
                                <img src="{{ asset('files/images/icons/trash-can-solid.svg') }}" alt="{{ __('Trash can') }}">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- If report is available, show it -->
        @if($instance->report)
            <hr>

            <div class="list__wrapper list__wrapper__flex">
                <div class="document__row">
                    <a href="{{ route('system.admin.trainings.instances.submodules.reports.download-report', ['instance_id' => $instance->id ]) }}" title="{{ __('Preuzmite izvještaj o provedenoj obuci') }}">
                        {{ __('Izvještaj o provedenoj obuci') }}
                    </a>

                    <div class="remove__icon" title="{{ __('Obrišite dokument') }}">
                        <a href="#">
                            <img src="{{ asset('files/images/icons/trash-can-solid.svg') }}" alt="{{ __('Trash can') }}">
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endif

<div class="rm-card-icons">
    <a title="{{ __('Upload dokumenata') }}" class="upload-files">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/cloud-arrow-up-solid.svg') }}" alt="{{ __('Upload file') }}">
        </div>
    </a>
    <a title="{{ __('Upload javnih dokumenata') }}" class="upload-public-files">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/upload-solid.svg') }}" alt="{{ __('Upload file') }}">
        </div>
    </a>
    <a href="{{ route('system.admin.trainings.instances.photo-gallery.preview', ['id' => $instance->id ]) }}" title="{{ __('Galerija fotografija') }}" class="instance-gallery">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/camera-retro-solid.svg') }}" alt="{{ __('Gallery image') }}">
        </div>
    </a>
</div>
