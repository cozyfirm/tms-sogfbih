@extends('public-part.auth.layout.auth-layout')
<!-- Title -->
@section('title') {{ __('Prijavite se') }} @endsection

<!-- Main section -->
@section('content')
    <div class="auth-form register-form">
        <div class="af-image rf-image">
            <img src="{{ asset('files/images/logo.svg') }}" alt="">
        </div>

        <div class="af-form rf-form">
            <div class="center-element">
                <div class="rf-f-header">
                    <div class="aff-header">
                        <h1 class="tb-color mb-4"> <b>{{ __('Kreirajte račun') }}</b> </h1>
                    </div>

                    <div class="aff-short">
                        <p class="my-font">
                            {{ __('Unesite Vaše osnovne informacije, kreirajte Vaš korisnički račun, i uživajte koristeći našu platformu!') }}
                        </p>
                    </div>

                    <div class="progress-line">
                        <div class="pl-e-bar"> <div class="pl-e-bar-fill"></div> </div>
                        <div class="pl-element pl-e-first">
                            <div class="pl-e-icon-w" title="{{ __('Lični podaci') }}">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="pl-element pl-e-second">
                            <div class="pl-e-icon-w" title="{{ __('Mjesto boravišta') }}">
                                <i class="fas fa-map-pin"></i>
                            </div>
                        </div>
                        <div class="pl-element pl-e-forth">
                            <div class="pl-e-icon-w" title="{{ __('Zahtjev poslan') }}">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rf-f-body">
                    <div class="rf-body-element rf-body-element-1 ">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ html()->label(__('Ime i prezime'))->for('name')->class('bold') }}
                                    {{ html()->text('name')->class('form-control form-control-sm mt-2')->maxlength(100)->value('') }}
                                    <small id="nameHelp" class="form-text text-muted">{{ __('Unesite Vaše ime prezime') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('Email adresa'))->for('email')->class('bold') }}
                                    {{ html()->email('email')->class('form-control form-control-sm mt-2')->maxlength(50)->value('') }}
                                    <small id="emailHelp" class="form-text text-muted">{{ __('Unesite Vašu email adresu') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('Šifra'))->for('password')->class('bold') }}
                                    {{ html()->password('password')->class('form-control form-control-sm mt-2')->value('') }}
                                    <small id="passwordHelp" class="form-text text-muted">{{ __('Unesite Vašu korisničku šifru') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('Broj telefona'))->for('phone')->class('bold') }}
                                    {{ html()->number('phone')->class('form-control form-control-sm mt-2')->maxlength(13)->value('') }}
                                    <small id="prefixHelp" class="form-text text-muted"> {{ __('Unesite Vaš broj telefona') }} </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('Datum rođenja'))->for('birth_date')->class('bold') }}
                                    {{ html()->text('birth_date')->class('form-control form-control-sm mt-2 datepicker')->maxlength('10')->value('') }}
                                    <small id="birth_dateHelp" class="form-text text-muted">{{ __('Unesite Vaš datum rođenja') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rf-body-element rf-body-element-2 d-none">
                        <div class="row">
                            <div class="col-md-6">
                                {{ html()->label(__('Adresa stanovanja'))->for('address')->class('bold') }}
                                {{ html()->text('address')->class('form-control form-control-sm mt-2')->maxlength('100')->value('') }}
                                <small id="addressHelp" class="form-text text-muted">{{ __('Vaša adresa stanovanja') }}</small>
                            </div>
                            <div class="col-md-6">
                                {{ html()->label(__('Grad'))->for('city')->class('bold') }}
                                {{ html()->text('city')->class('form-control form-control-sm mt-2')->maxlength('50')->value('') }}
                                <small id="living_placeHelp" class="form-text text-muted">{{ __('Grad u kojem trenutno živite') }}</small>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{ html()->label(__('Država'))->for('country')->class('bold') }}
                                    {{ html()->select('country', $countries, 21)->class('form-control form-control-sm mt-2')->options([]) }}
                                    <small id="countryHelp" class="form-text text-muted"> {{ __('Odaberite državu u kojoj trenutno živite') }} </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rf-body-element rf-body-element-4 pb-4 d-none">
                        <p>
                            {{ __('Vaš korisnički račun / profil na sistemu www.talentakademija.ba je uspješno kreiran. Za verifikaciju Vašeg email-a, molimo slijedite upute poslane putem email-a.') }}
                            <br>
                            <b>{{ __('Napomena:') }}</b>
                            {{ __('Ukoliko ne dobijete email unutar 5 minuta, provjerite junk (spam) folder, ili nas kontaktirajte putem email-a!') }}
                        </p>
                    </div>

                    <div class="row mt-3 pt-4 pb-4 back-next-btn-wrapper">
                        <div class="col-md-12 d-flex justify-content-end">
                            <div class="button-wrapper create-profile-back-btn d-none">
                                <b>{{__('Nazad')}}</b>
                            </div>
                            <div class="button-wrapper create-profile-next-btn">
                                <b>{{__('Sljedeći korak')}}</b>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row pt-4">
                        <div class="col-md-12 my-font">
                            {{ __('Imate kreiran račun?') }} <a href="{{ route('auth') }}"><b>{{ __('Prijavite se') }}</b></a>
                        </div>
                    </div>
                    {{--                {{ html()->form('POST', route('auth.save-account'))->open() }}--}}
                    {{--                {{ html()->form()->close() }}--}}
                </div>
            </div>
        </div>
    </div>
@endsection
