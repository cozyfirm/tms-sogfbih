<div class="questionnaire__wrapper">

    {{ html()->hidden('evaluation_id')->class('form-control')->value($evaluation->id) }}

    <div class="questionnaire__inner">
        <div class="questionnaire__description">
            <h2>{{ __('OBRAZAC ZA EVALUACIU OBUKE') }}</h2>
            <p><i>{{ __('Pažljivo pročitajte sljedeće izjave i naznačite vaš nivo saglasnosti označavajući odgovarajuću kockicu. Imate šest mogućih odgovora u rasponu od "totalno se ne slažem" do "potpuno se slažem". Ako ne možete odgovoriti ili ne želite, označite polje "bez odgovora“.') }}</i></p>
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
                                        <p>{{ __('Nema') }} <br> odgovora</p>
                                    </div>
                                </div>
                                @foreach($group->getByGroupWithAnswers($group->evaluation_id, $group->group_by) as $question)
                                    @php $answer = EvaluationsHelper::isChecked($evaluation->id, $question->id); @endphp
                                    <div class="st__row">
                                        <div class="st__row__question">
                                            <p>{{ $question->question ?? '' }}</p>
                                        </div>
                                        @for($i=1; $i<=6; $i++)
                                            <div class="st__row_radio__wrapper" title="@if($i<6) {{ __('Ekvivalent ocjene ') . $i }} @else {{ __('Ne želim se izjasniti') }} @endif">
                                                <input type="radio" class="question__radio" value="{{ ($i == 6) ? 0 : $i }}" name="question_id_{{ $question->id }}" id="{{ $question->id }}" @if($i==$answer) checked @endif>
                                            </div>
                                        @endfor
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($group->getByGroupQuestionOnly($group->evaluation_id, $group->group_by)->count())
                            <div class="section__body">
                                @foreach($group->getByGroupQuestionOnly($group->evaluation_id, $group->group_by) as $question)
                                    @php $answer = EvaluationsHelper::getAnswer($evaluation->id, $question->id); @endphp

                                    <div class="section__question">
                                        <div class="sq__header">
                                            <p>{{ $question->question ?? '' }}</p>
                                        </div>
                                        <div class="sq__body">
                                            {{ html()->textarea('answer')->class('form-control form-control-sm question__answer')->id($question->id)->value($answer)->isReadonly(false) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if(!isset($status))
            <div class="submit__wrapper">
                <button type="submit" class="yellow-btn" id="save-evaluation"> {{ __('SAČUVAJ EVALUACIJU') }} </button>
            </div>
        @endif
    </div>
</div>
