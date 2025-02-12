<div class="three__elements">
    <div class="element">
        <h5>5</h5>
        <p>Mojih obuka</p>
    </div>
    <div class="element">
        <h5>3</h5>
        <p>Certifikata</p>
    </div>
    <div class="element">
        <h5>24</h5>
        <p>Sati predavanja</p>
    </div>
</div>

<div class="rm-card">
    <div class="rm-card-header" title="{{ __('Moje posljednje obuke') }}">
        <h5>{{ __('Posljednje obuke') }}</h5>
        <img class="normal-icon" src="{{ asset('files/images/icons/training.svg') }}" alt="{{ __('Training image') }}">
    </div>
    <hr>
    <div class="list__wrapper">
        <ol>
            <li>
                <a href="#}">
                    Program za inostrane zaposlenike
                </a>
            </li>
            <li>
                <a href="#}">
                    Škola Cpp-a za početnike
                </a>
            </li>
        </ol>
    </div>
</div>

<div class="rm-card-icons">
    <a href="{{ route('system.user-data.my-profile.education') }}" title="{{ __('Stručna sprema') }}" class="open-add-author">
        <div class="rm-ci-w">
            <img class="normal-icon" src="{{ asset('files/images/icons/building-columns-solid.svg') }}" alt="{{ __('University image') }}">
        </div>
    </a>
    <a href="#" title="">
        <div class="rm-ci-w">
            <img src="{{ asset('files/images/icons/category.svg') }}" alt="{{ __('Category image') }}">
        </div>
    </a>
</div>
