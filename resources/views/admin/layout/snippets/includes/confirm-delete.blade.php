<div class="confirm-delete d-none">
    <div class="part_inner_wrapper">
        <div class="header">
            <div class="left-btn delete-note"> {{ __('Brisanje') }} </div>
            <div class="img_and_btn_wrapper">
                <img class="close-confirm-delete" src="{{ asset('files/images/icons/cross-small.svg') }}" alt="{{ __('Close icon') }}" title="{{ __('Zatvorite skočni prozor') }}">
            </div>
        </div>
        <div class="header__info">
            <h3 class="delete-title">{{ __('UPOZORENJE') }}</h3>
            <p class="delete-desc">{{ __('Da li ste sigurni da želite nastaviti sa brisanjem?') }}</p>
        </div>

        <div class="body__wrapper">
            <div class="row mt-4 mb-5">
                <div class="col-md-12 d-flex justify-content-center gap-4">
                    <button type="submit" class="table-btn confirm-delete-cancel" title="{{ __('Odustanite od brisanja') }}">  {{ __('ODUSTANITE') }} </button>
                    <button type="submit" class="yellow-btn confirm-delete-delete" title="{{ __('Nastavite sa brisanjem') }}">  {{ __('OBRIŠITE') }} </button>
                </div>
            </div>
        </div>
    </div>
</div>
