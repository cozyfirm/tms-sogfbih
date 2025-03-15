<div class="three__elements">
    <div class="element" title="{{ __('Broj učesnika') }}">
        <h5>{{ __('12') }}</h5>
        <p>{{ __('Učesnika') }}</p>
    </div>
    <div class="element" title="{{ __('Broj unesenih zaključaka sa događaja') }}">
        <h5>0</h5>
        <p>{{ __('Posjeta') }}</p>
    </div>
    <div class="element" title="{{ __('Broj priloženih dokumenata') }}">
        <h5> {{ $analysis->evaluationRel->optionsRel->count() }} </h5>
        <p>{{ __('Pitanja') }}</p>
    </div>
</div>

<div class="rm-card">
    <div class="rm-card-header">
        <h5>{{ __('Posljednje ankete') }}</h5>
        <i class="fa-solid fa-note-sticky"></i>
    </div>
    <hr>
    <div class="list__wrapper">
        <ol>
            @for($i=0; $i<3; $i++)
                <li> {{ date('d.m.Y H:i') }}h </li>
            @endfor
        </ol>
    </div>
</div>

<div class="rm-card-icons">
    <a href="{{ route('system.admin.other.analysis.submodules.evaluations.preview', ['analysis_id' => $analysis->id ]) }}" title="{{ __('Pitanja za anketu') }}">
        <div class="rm-ci-w">
            <i class="fa-solid fa-user-pen"></i>
        </div>
    </a>
    <a title="{{ __('Preuzmite izvještaj') }}" class="upload-files">
        <div class="rm-ci-w">
            <i class="fa-solid fa-clipboard"></i>
        </div>
    </a>
</div>
