<div class="add__author_wrapper">
    <div class="aa_inner_wrapper">
        <div class="header">
            <div class="left-btn"> {{ __('Autori programa') }} </div>
            <div class="img_and_btn_wrapper">
                <div class="switch"><div class="circle"></div></div>
                <img src="{{ asset('files/images/icons/cross-small.svg') }}" alt="{{ __('Close icon') }}" title="{{ __('Zatvorite skočni prozor') }}">
            </div>
        </div>
        <div class="header__info">
            <h3>Autori programa</h3>
            <p>Unesite ili odaberite autora programa obuke</p>
        </div>

        <div class="body__wrapper">
            <div class="ta_search__author  d-none">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ html()->label(__('Autor programa obuke'))->for('project')->class('bold') }}
                            {{ html()->select('project', $projects, '')->class('form-control form-control-sm ')->required() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="ta_insert__author">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ html()->label(__('Fizičko ili pravno lice'))->for('project')->class('bold') }}
                            {{ html()->select('project', $projects, '')->class('form-control form-control-sm')->required() }}
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Ime i prezime'))->for('title')->class('bold') }}
                            {{ html()->text('title', '' )->class('form-control form-control-sm')->required()->maxlength(200) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Email'))->for('email')->class('bold') }}
                            {{ html()->text('email', '' )->class('form-control form-control-sm')->required()->maxlength(200) }}
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Adresa'))->for('address')->class('bold') }}
                            {{ html()->text('address', '' )->class('form-control form-control-sm')->required()->maxlength(200) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Grad'))->for('city')->class('bold') }}
                            {{ html()->select('city', $cities, '')->class('form-control form-control-sm select-2')->required() }}
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Telefon'))->for('phone')->class('bold') }}
                            {{ html()->text('phone', '' )->class('form-control form-control-sm')->required()->maxlength(200) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Mobitel'))->for('cellphone')->class('bold') }}
                            {{ html()->text('cellphone', '' )->class('form-control form-control-sm')->required()->maxlength(200) }}
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ html()->label(__('Napomena'))->for('comment')->class('bold') }}
                            {{ html()->textarea('comment', '' )->class('form-control form-control-sm')->required()->maxlength(200)->style('height:80px;') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="yellow-btn">  {{ __('SAČUVAJTE') }} </button>
                </div>
            </div>
        </div>
    </div>
</div>
