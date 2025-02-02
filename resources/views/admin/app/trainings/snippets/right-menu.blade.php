<div class="three__elements">
    <div class="element">
        <h5>5</h5>
        <p>Obuka</p>
    </div>
    <div class="element">
        <h5>186</h5>
        <p>Polaznika</p>
    </div>
    <div class="element">
        <h5>7</h5>
        <p>Trenera</p>
    </div>
</div>

<div class="rm-card">
    <div class="rm-card-header">
        <h5>{{ __('Posljednje obuke') }}</h5>
        <img class="normal-icon" src="{{ asset('files/images/icons/training-instance.svg') }}" alt="{{ __('Training-instance image') }}">
    </div>
    <hr>
    <div class="list__wrapper">
        <ol>
            @foreach($training->instancesRel as $instance)
                <li>
                    <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}">
                        {{ $instance->startDate() }} - {{ $instance->endDate() }} (12 polaznika)
                    </a>
                </li>
            @endforeach
        </ol>
    </div>
</div>

<div class="rm-card">
    <div class="rm-card-header">
        <h5>{{ __('Priloženi dokumenti') }}</h5>
        <img class="normal-icon" src="{{ asset('files/images/icons/folder-open-regular.svg') }}" alt="{{ __('Training-instance image') }}">
    </div>
    <hr>
    <div class="list__wrapper list__wrapper__flex">
        @php $counter = 1; @endphp
        @foreach($training->filesRel as $file)
            <div class="document__row">
                <a href="{{ route('system.admin.trainings.download-file', ['id' => $file->id ]) }}" title="{{ __('Preuzmite dokument') }}">
                    {{ $counter++ }}. {{ $file->fileRel->file ?? '' }}
                </a>

                <div class="remove__icon" title="{{ __('Obrišite dokument') }}">
                    <a href="{{ route('system.admin.trainings.remove-file', ['id' => $file->id]) }}">
                        <img src="{{ asset('files/images/icons/trash-can-solid.svg') }}" alt="{{ __('Trash can') }}">
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="rm-card-icons">
    <a title="{{ __('Autori prorama obuke') }}" class="open-add-author">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/author.svg') }}" alt="{{ __('Category image') }}">
        </div>
    </a>
    <a href="{{ route('system.admin.core.keywords.preview-instances', ['key' => 'trainings__areas']) }}" title="{{ __('Šifarnik oblasti kojima programi pripadaju') }}">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/category.svg') }}" alt="{{ __('Category image') }}">
        </div>
    </a>
    <a title="{{ __('Upload dokumenata') }}" class="upload-files">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/cloud-arrow-up-solid.svg') }}" alt="{{ __('Category image') }}">
        </div>
    </a>
</div>
