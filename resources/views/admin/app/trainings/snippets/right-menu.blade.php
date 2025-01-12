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
    <a href="#" title="{{ __('Šire oblasti kojima pripada program obuke') }}">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/category.svg') }}" alt="{{ __('Category image') }}">
        </div>
    </a>
</div>
