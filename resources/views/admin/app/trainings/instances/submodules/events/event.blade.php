<div class="add__agenda_wrapper d-none">
    <div class="ag_inner_wrapper">
        <div class="header">
            <div class="left-btn add-agenda-note"> {{ __('Agenda') }} </div>
            <div class="img_and_btn_wrapper">
                <img class="close-add-agenda" src="{{ asset('files/images/icons/cross-small.svg') }}" alt="{{ __('Close icon') }}" title="{{ __('Zatvorite skočni prozor') }}">
            </div>
        </div>
        <div class="header__info">
            <h3 class="add-agenda-title">{{ __('Događaj') }}</h3>
            <p class="add-agenda-desc">{{ __('Događaji na obuci - Raspored ili pauza za ručak') }}</p>
        </div>

        <div class="body__wrapper">
            {{ html()->hidden('ag_instance_id')->class('form-control at_instance_id')->value($instance->id) }}

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ html()->label(__('Vrsta događaja'))->for('ag_type')->class('bold') }}
                        {{ html()->select('ag_type', $events, '1')->class('form-control form-control-sm single-select2 ag_type')->style('width:100%;')->required() }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ html()->label(__('Lokacija'))->for('ag_location_id')->class('bold') }}
                        {{ html()->select('ag_location_id', $locations, '')->class('form-control form-control-sm single-select2 ag_location_id')->style('width:100%;')->required() }}
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ html()->label(__('Datum'))->for('ag_date')->class('bold') }}
                        {{ html()->text('ag_date', date('d.m.Y') )->class('form-control form-control-sm ag_date datepicker c-dp')->required()->maxlength(10) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ html()->label(__('Vrijeme početka'))->for('ag_tf')->class('bold') }}
                        {{ html()->select('ag_tf', $time, '08:00')->class('form-control form-control-sm select2 ag_tf')->style('width:100%;')->required() }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ html()->label(__('Vrijeme završetka'))->for('ag_td')->class('bold') }}
                        {{ html()->select('ag_td', $time, '08:00')->class('form-control form-control-sm select2 ag_td')->style('width:100%;')->required() }}
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="form-group">
                        {{ html()->label(__('Napomena'))->for('ag_note')->class('bold') }}
                        {{ html()->textarea('ag_note', '' )->class('form-control form-control-sm ag_note')->style('height:80px;') }}
                        <small id="ag_noteHelp" class="form-text text-muted">{{ __('Dodatna napomena (neobavezno polje)') }}</small>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 d-flex justify-content-end gap-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="ag_repeat" name="ag_repeat">
                        <label class="form-check-label" for="ag_repeat">{{ __('Ponovite unos') }}</label>
                    </div>

                    <button type="submit" class="table-btn remove-event d-none">  {{ __('OBRIŠITE') }} </button>
                    <button type="submit" class="yellow-btn save-event">  {{ __('SAČUVAJTE') }} </button>
                </div>
            </div>
        </div>
    </div>
</div>
