<div class="add__author_wrapper d-none">
    <div class="aa_inner_wrapper">
        <div class="header">
            <div class="left-btn add-author-note"> {{ __('Pretraga autora') }} </div>
            <div class="img_and_btn_wrapper">
                <div class="switch add-author-switch" state="off"><div class="circle"></div></div>
                <img class="close-add-author" src="{{ asset('files/images/icons/cross-small.svg') }}" alt="{{ __('Close icon') }}" title="{{ __('Zatvorite skočni prozor') }}">
            </div>
        </div>
        <div class="header__info">
            <h3>Autori programa</h3>
            <p>Unesite ili odaberite autora programa obuke</p>
        </div>

        <div class="body__wrapper">
            {{ html()->hidden('author_training_id')->class('form-control author_training_id')->value($training->id) }}

            <div class="ta_search__author">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ html()->label(__('Autor programa obuke'))->for('search_author')->class('bold') }}
                            {{ html()->select('search_author', $authors, '')->class('form-control form-control-sm single-select2 search_author')->style('width:100%;')->required() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="ta_insert__author d-none">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ html()->label(__('Fizičko ili pravno lice'))->for('author_type')->class('bold') }}
                            {{ html()->select('author_type', $userTypes, '')->class('form-control form-control-sm author_type')->required() }}
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Ime i prezime'))->for('author_title')->class('bold author_title_label') }}
                            {{ html()->text('author_title', '' )->class('form-control form-control-sm author_title')->required()->maxlength(200) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Email'))->for('author_email')->class('bold') }}
                            {{ html()->text('author_email', '' )->class('form-control form-control-sm author_email')->required()->maxlength(200) }}
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Adresa'))->for('author_address')->class('bold') }}
                            {{ html()->text('author_address', '' )->class('form-control form-control-sm author_address')->required()->maxlength(200) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Grad'))->for('author_city')->class('bold') }}
                            {{ html()->select('author_city', $cities, '')->class('form-control form-control-sm single-select2 author_city')->style('width:100%;')->required() }}
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Broj telefona'))->for('author_phone')->class('bold') }}
                            {{ html()->text('author_phone', '+387 ' )->class('form-control form-control-sm author_phone')->required()->maxlength(200) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Broj mobitela'))->for('author_cellphone')->class('bold') }}
                            {{ html()->text('author_cellphone', '+387 ' )->class('form-control form-control-sm author_cellphone')->required()->maxlength(200) }}
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ html()->label(__('Napomena'))->for('author_comment')->class('bold') }}
                            {{ html()->textarea('author_comment', '' )->class('form-control form-control-sm author_comment')->required()->maxlength(200)->style('height:80px;') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="yellow-btn save-author">  {{ __('SAČUVAJTE') }} </button>
                </div>
            </div>
        </div>
    </div>
</div>
