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
            @for($i=0; $i<5; $i++)
                <li> Testni instance obuke koja se održala nekad u toku prošlog mjeseca </li>
            @endfor
        </ol>
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
