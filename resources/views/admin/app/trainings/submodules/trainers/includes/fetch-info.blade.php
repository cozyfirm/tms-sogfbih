<div class="fetch__trainer_info d-none">
    <div class="fti_inner_wrapper">
        <div class="header">
            <div class="left-btn fetch-trainer-info-note"> {{ __('Detaljne informacije') }} </div>
            <div class="img_and_btn_wrapper">
                <img class="close-fetch-trainer" src="{{ asset('files/images/icons/cross-small.svg') }}" alt="{{ __('Close icon') }}" title="{{ __('Zatvorite skočni prozor') }}">
            </div>
        </div>
        <div class="header__info">
            <h3 class="fetch-trainer-info-title">{{ $user->name ?? '' }}</h3>
            <p class="fetch-trainer-info-desc">{{ __('Pregled angažovanosti trenera na obuci') }}</p>
        </div>

        <div class="body__wrapper">
            <div class="row mt-1">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ html()->label(__('Postignuta ocjena trenera na obuci'))->for('fti_grade')->class('bold') }}
                        {{ html()->number('fti_grade', '', '0.0', '10.0', '0.1' )->class('form-control form-control-sm fti_grade')->isReadonly(true) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ html()->label(__('Vrijednost ugovora'))->for('fti_contract')->class('bold') }}
                        {{ html()->number('fti_contract', '', '0.0', '10000.0', '0.01' )->class('form-control form-control-sm fti_contract')->isReadonly(true) }}
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="form-group">
                        {{ html()->label(__('Monitoring trenera'))->for('fti_monitoring')->class('bold') }}
                        {{ html()->textarea('fti_monitoring', '' )->class('form-control form-control-sm fti_monitoring')->style('height:120px;')->isReadonly(true) }}
                        <small id="fti_monitoringHelp" class="form-text text-muted">{{ __('Više informacija o monitoringu trenera') }}</small>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 d-flex justify-content-end gap-3">
                    <button class="yellow-btn fti-preview-instance">  {{ __('PREGLED OBUKE') }} </button>
                </div>
            </div>
        </div>
    </div>
</div>
