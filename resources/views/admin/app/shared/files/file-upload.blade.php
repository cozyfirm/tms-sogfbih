<div class="file__upload__wrapper d-none">
    <div class="file__upload_inner">
        <div class="header">
            <div class="left-btn add-author-note"> {{ __('Dokumenti') }} </div>
            <div class="img_and_btn_wrapper">
                <img class="close-file-upload" src="{{ asset('files/images/icons/cross-small.svg') }}" alt="{{ __('Close icon') }}" title="{{ __('Zatvorite skočni prozor') }}">
            </div>
        </div>
        <div class="header__info">
            <h3 class="add-author-title">{{ __('Unos dokumenata') }}</h3>
            <p class="add-author-desc">{{ __('Odaberite dokumente koje želite unijeti za ovaj program') }}</p>
        </div>

        <label for="files" class="upload__form">
            <div class="upload__middle">
                <div class="svg__wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128l-368 0zm79-217c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39L296 392c0 13.3 10.7 24 24 24s24-10.7 24-24l0-134.1 39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z"/>
                    </svg>
                </div>
                <h6>{{ __('Odaberite željene dokumente') }}</h6>
            </div>
        </label>

        <div class="uploaded__files__wrapper">
            @for($i=0; $i<0; $i++)
                <div class="uploaded__file">
                    <div class="file__header">
                        <div class="icon__wrapper">
                            <img src="{{ asset('files/images/icons/ext/excel.png') }}" alt="{{ __('Icon') }}">
                        </div>
                        <div class="content__wrapper">
                            <h6>Table Name.xls</h6>
                            <p>3 MB</p>
                        </div>
                        <div class="content__remove" title="{{ __('Obrišite ovaj dokument') }}">
                            <img class="remove-file-icon" src="{{ asset('files/images/icons/cross-small.svg') }}" alt="{{ __('Remove icon') }}">
                        </div>
                    </div>
                    <div class="upload__progress_wrapper">
                        <div class="upload__line"><div class="upload__line_fill"></div></div>
                        <p>35%</p>
                    </div>
                </div>
            @endfor
        </div>

        <input type="file" name="files[]" class="d-none" id="files" multiple>

        <div class="upload__buttons_wrapper">
            <button type="submit" class="table-btn fu-remove-files">  {{ __('Odustani') }} </button>
            <button type="button" class="yellow-btn fu-save-files">  {{ __('Sačuvaj') }} </button>
        </div>
    </div>
</div>
