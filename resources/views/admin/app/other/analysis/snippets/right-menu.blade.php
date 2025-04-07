<div class="three__elements">
    <div class="element" title="{{ __('Broj učesnika') }}">
        <h5>@isset($analysis->evaluationRel) {{ $analysis->evaluationRel->publicQuestionnairesRel->count() }} @else 0 @endif</h5>
        <p>{{ __('Učesnika') }}</p>
    </div>
    <div class="element" title="{{ __('Broj unesenih zaključaka sa događaja') }}">
        <h5>@isset($analysis->evaluationRel) {{ $analysis->evaluationRel->publicQuestionnairesAllRel->count() }} @else 0 @endif</h5>
        <p>{{ __('Posjeta') }}</p>
    </div>
    <div class="element" title="{{ __('Broj priloženih dokumenata') }}">
        <h5>@isset($analysis->evaluationRel) {{ $analysis->evaluationRel->optionsRel->count() }} @else 0 @endif</h5>
        <p>{{ __('Pitanja') }}</p>
    </div>
</div>

@if(isset($analysis->evaluationRel) and $analysis->evaluationRel->publicQuestionnairesRel->count())
    <div class="rm-card">
        <div class="rm-card-header">
            <h5>{{ __('Posljednje ankete') }}</h5>
            <i class="fa-solid fa-note-sticky"></i>
        </div>
        <hr>
        <div class="list__wrapper list__wrapper__flex">
            @php $counter = 1; @endphp
            @foreach($analysis->evaluationRel->publicQuestionnairesRel as $questionnaire)
                <div class="document__row">
                    <a href="{{ route('public-data.analysis.preview', ['hash' => $analysis->hash, 'id' => $questionnaire->id ]) }}" target="_blank" title="{{ __('Pregled ankete') }}">
                        {{ $counter++ }}. {{ $questionnaire->userRel->name ?? '' }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif

<div class="rm-card-icons">
    <a href="{{ route('system.admin.other.analysis.submodules.evaluations.preview', ['analysis_id' => $analysis->id ]) }}" title="{{ __('Pitanja za anketu') }}">
        <div class="rm-ci-w">
            <i class="fa-solid fa-user-pen"></i>
        </div>
    </a>
    <a title="{{ __('Kopirajte link') }}" class="copy-analysis-uri" uri="{{ route('public-data.analysis', ['hash' => $analysis->hash ]) }}">
        <div class="rm-ci-w">
            <i class="fa-solid fa-clipboard"></i>
        </div>
    </a>
    <a href="{{ route('system.admin.other.analysis.submodules.downloads.get-report', ['analysis_id' => $analysis->id ]) }}" title="{{ __('Preuzmite izvještaj') }}">
        <div class="rm-ci-w">
            <i class="fa-solid fa-download"></i>
        </div>
    </a>
</div>
