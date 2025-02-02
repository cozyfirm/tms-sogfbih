<div class="three__elements">
    <div class="element" title="{{ __('Broj prijava na obuci') }}">
        <h5>65</h5>
        <p>Prijava</p>
    </div>
    <div class="element" title="{{ __('Broj polaznika na obuci') }}">
        <h5>24</h5>
        <p>Polaznika</p>
    </div>
    <div class="element" title="{{ __('Trajanje obuke') }}">
        <h5>5</h5>
        <p>Dana</p>
    </div>
</div>

<div class="rm-card">
    <div class="rm-card-header">
        <h5>{{ __('Posljednje prijave') }}</h5>
        <img class="normal-icon" src="{{ asset('files/images/icons/training-instance.svg') }}" alt="{{ __('Training-instance image') }}">
    </div>
    <hr>
    <div class="list__wrapper">
        <ol>
            @for($i=0; $i<5; $i++)
                <li> Šemso Poplava </li>
            @endfor
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
{{--        @foreach($training->filesRel as $file)--}}
{{--            <div class="document__row">--}}
{{--                <a href="{{ route('system.admin.trainings.download-file', ['id' => $file->id ]) }}" title="{{ __('Preuzmite dokument') }}">--}}
{{--                    {{ $counter++ }}. {{ $file->fileRel->file ?? '' }}--}}
{{--                </a>--}}

{{--                <div class="remove__icon" title="{{ __('Obrišite dokument') }}">--}}
{{--                    <a href="{{ route('system.admin.trainings.remove-file', ['id' => $file->id]) }}">--}}
{{--                        <img src="{{ asset('files/images/icons/trash-can-solid.svg') }}" alt="{{ __('Trash can') }}">--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}
    </div>
</div>

<div class="rm-card-icons">
    <a title="{{ __('Dodajte trenera na obuku') }}" class="instances-add-trainer">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/trainer.svg') }}" alt="{{ __('Trainer image') }}">
        </div>
    </a>
    <a title="{{ __('Upload dokumenata') }}" class="upload-files">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/cloud-arrow-up-solid.svg') }}" alt="{{ __('Upload image') }}">
        </div>
    </a>
    <a href="{{ route('system.admin.trainings.instances.photo-gallery.preview', ['id' => $instance->id ]) }}" title="{{ __('Galerija fotografija') }}" class="instance-gallery">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/camera-retro-solid.svg') }}" alt="{{ __('Gallery image') }}">
        </div>
    </a>
</div>
