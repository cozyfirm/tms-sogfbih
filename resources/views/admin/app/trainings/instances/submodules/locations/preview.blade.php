<div class="preview__location_wrapper d-none">
    <div class="pl_inner_wrapper">
        <div class="header">
            <div class="left-btn preview-location-note"> {{ __('Lokacija') }} </div>
            <div class="img_and_btn_wrapper">
                <img class="close-preview-location" src="{{ asset('files/images/icons/cross-small.svg') }}" alt="{{ __('Close icon') }}" title="{{ __('Zatvorite skočni prozor') }}">
            </div>
        </div>
        <div class="header__info">
            <h3 class="preview-location-title"></h3>
            <p class="preview-location-desc">{{ __('Detaljne informacije o mjestu događaja') }}</p>
        </div>

        <div class="body__wrapper">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ html()->label(__('Adresa'))->for('pl_address')->class('bold') }}
                        {{ html()->text('pl_address')->class('form-control form-control-sm pl_address')->isReadonly() }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ html()->label(__('Grad'))->for('pl_city')->class('bold') }}
                        {{ html()->text('pl_city')->class('form-control form-control-sm pl_city')->isReadonly() }}
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ html()->label(__('Kontakt telefon'))->for('pl_phone')->class('bold') }}
                        {{ html()->text('pl_phone')->class('form-control form-control-sm pl_phone')->isReadonly() }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ html()->label(__('Email adresa'))->for('pl_email')->class('bold') }}
                        {{ html()->text('pl_email')->class('form-control form-control-sm pl_email')->isReadonly() }}
                    </div>
                </div>
            </div>

            <div class="row mt-2 d-none">
                <div class="pl__map_wrapper"></div>
            </div>

            @if(Auth()->user()->role == 'admin' or Auth()->user()->role == 'moderator')
                <div class="row mt-4">
                    <div class="col-md-12 d-flex justify-content-end gap-3">
                        <a href="#" target="_blank" class="pl-uri" title="{{ __('Uredite informacije o lokaciji') }}">
                            <button type="button" class="yellow-btn">  {{ __('Više informacija') }} </button>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
