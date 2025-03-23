<div class="participants d-none">
    <div class="part_inner_wrapper">
        <div class="header">
            <div class="left-btn participants-note"> {{ __('Učesnici događaja') }} </div>
            <div class="img_and_btn_wrapper">
                <img class="close-preview-participants" src="{{ asset('files/images/icons/cross-small.svg') }}" alt="{{ __('Close icon') }}" title="{{ __('Zatvorite skočni prozor') }}">
            </div>
        </div>
        <div class="header__info">
            <h3 class="participants-title">{{ __('Dodajte učesnika') }}</h3>
            <p class="participants-desc">{{ __('Unesite puno ime i prezime učesnika događaja') }}</p>
        </div>

        <div class="body__wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {{ html()->label(__('Ime i prezime'))->for('participant_name')->class('bold') }}
                        {{ html()->text('participant_name')->class('form-control form-control-sm participant_name') }}
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 d-flex justify-content-end gap-3">
                    <div class="form-check form-check-inline participants__repeat">
                        <input class="form-check-input" type="checkbox" id="pr__checkbox" name="pr__checkbox">
                        <label class="form-check-label" for="pr__checkbox">{{ __('Ponovite unos') }}</label>
                    </div>

                    <button type="submit" class="table-btn remove-participant d-none">  {{ __('OBRIŠITE') }} </button>
                    <button type="submit" class="yellow-btn save-participant">  {{ __('SAČUVAJTE') }} </button>
                </div>
            </div>
        </div>
    </div>
</div>
