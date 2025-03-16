<html>
<head>
    <title>{{ $analysis->title ?? '' }}</title>
    <script src="https://kit.fontawesome.com/e3d0ab8b0c.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('files/images/favicon.ico') }}"/>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.scss', 'resources/css/admin/admin.scss', 'resources/js/app.js'])
</head>
<body>

<div class="questionnaire__public d-flex">

    {{ html()->hidden('evaluation_id')->class('form-control')->value($evaluation->id) }}
    {{ html()->hidden('submission_status')->class('form-control')->value($evaluationAnalysis->status) }}

    <div class="questionnaire__inner">
        <div class="questionnaire__description">
            <h2>{{ $analysis->title ?? '' }} </h2>
            @if(!isset($preview))
                <p>{!! nl2br($analysis->description ?? '') !!}</p>

                <p><i>{{ __('Pažljivo pročitajte sljedeće izjave i naznačite vaš nivo saglasnosti označavajući odgovarajuću kockicu. Imate šest mogućih odgovora u rasponu od "totalno se ne slažem" do "potpuno se slažem". Ako ne možete odgovoriti ili ne želite, označite polje "bez odgovora“.') }}</i></p>
            @endif
        </div>

        <div class="question__wrapper">
            @foreach($groups as $group)
                <div class="section__wrapper">
                    <div class="section__header">
                        <h5>{{ $group->groupRel->name ?? '' }}</h5>
                    </div>
                    <div class="section__body">
                        @if($group->getByGroupWithAnswers($group->evaluation_id, $group->group_by)->count())
                            <div class="section__table">
                                <div class="st__header">
                                    <div class="st__header__info">
                                        <p>{{ __('Totalno se ne slažem') }}</p>
                                        <p>{{ __('Potpuno se slažem') }}</p>
                                    </div>
                                    <div class="st__header__last">
                                        <p>{{ __('Nema') }} <br> {{ __('odgovora') }}</p>
                                    </div>
                                </div>
                                @foreach($group->getByGroupWithAnswers($group->evaluation_id, $group->group_by) as $question)
                                    @php $answer = EvaluationsHelper::pIsChecked($evaluation->id, $question->id, $evaluationAnalysis->id); @endphp
                                    <div class="st__row">
                                        <div class="st__row__question">
                                            <p>{{ $question->question ?? '' }}</p>
                                        </div>
                                        @for($i=1; $i<=6; $i++)
                                            <div class="st__row_radio__wrapper" title="@if($i<6) {{ __('Ekvivalent ocjene ') . $i }} @else {{ __('Ne želim se izjasniti') }} @endif">
                                                <input type="radio" class="public_question__radio" value="{{ ($i == 6) ? 0 : $i }}" name="question_id_{{ $question->id }}" id="{{ $question->id }}" @if($i==$answer) checked @endif @if($evaluationAnalysis->status == 'submitted') disabled @endif>
                                            </div>
                                        @endfor
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($group->getByGroupQuestionOnly($group->evaluation_id, $group->group_by)->count())
                            <div class="section__body">
                                @foreach($group->getByGroupQuestionOnly($group->evaluation_id, $group->group_by) as $question)
                                    @php $answer = EvaluationsHelper::pGetAnswer($evaluation->id, $question->id, $evaluationAnalysis->id); @endphp

                                    <div class="section__question">
                                        <div class="sq__header">
                                            <p>{{ $question->question ?? '' }}</p>
                                        </div>
                                        <div class="sq__body">
                                            {{ html()->textarea('answer')->class('form-control form-control-sm public_question__answer')->id($question->id)->value($answer)->isReadonly($evaluationAnalysis->status == 'submitted') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if($evaluationAnalysis->status != 'submitted')
            <div class="submit__wrapper">
                <button type="submit" class="yellow-btn" id="save-public-evaluation"> {{ __('ZAVRŠITE SA ANKETOM') }} </button>
            </div>
        @endif
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"> </script>
</body>
</html>
