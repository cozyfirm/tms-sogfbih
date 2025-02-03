<div class="add__trainer_wrapper d-none">
    <div class="at_inner_wrapper">
        <div class="header">
            <div class="left-btn add-trainer-note"> {{ __('Pretraga trenera') }} </div>
            <div class="img_and_btn_wrapper">
                <img class="close-add-trainer" src="{{ asset('files/images/icons/cross-small.svg') }}" alt="{{ __('Close icon') }}" title="{{ __('Zatvorite skočni prozor') }}">
            </div>
        </div>
        <div class="header__info">
            <h3 class="add-trainer-title">{{ __('Treneri obuka') }}</h3>
            <p class="add-trainer-desc">{{ __('Odaberite trenera na ovoj obuci') }}</p>
        </div>

        <div class="body__wrapper">
            {{ html()->hidden('author_training_id')->class('form-control author_training_id')->value(12) }}

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ html()->label(__('Ime i prezime trenera'))->for('at_trainer_id')->class('bold') }}
                        {{ html()->select('at_trainer_id', $trainers, '')->class('form-control form-control-sm single-select2 at_trainer_id')->style('width:100%;')->required() }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ html()->label(__('Postignuta ocjena trenera na obuci'))->for('at_grade')->class('bold') }}
                        {{ html()->number('at_grade', '', '0.0', '10.0', '0.1' )->class('form-control form-control-sm at_grade')->maxlength(200) }}
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-md-12">
                    <div class="form-group">
                        {{ html()->label(__('Monitoring trenera'))->for('at_monitoring')->class('bold') }}
                        {{ html()->textarea('at_monitoring', '' )->class('form-control form-control-sm at_monitoring')->style('height:80px;') }}
                        <small id="at_monitoringHelp" class="form-text text-muted">{{ __('Više informacija o monitoringu trenera') }}</small>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 d-flex justify-content-end gap-3">
                    <button type="submit" class="table-btn remove-trainer d-none">  {{ __('OBRIŠITE') }} </button>
                    <button type="submit" class="yellow-btn save-trainer">  {{ __('SAČUVAJTE') }} </button>
                </div>
            </div>
        </div>
    </div>
</div>
