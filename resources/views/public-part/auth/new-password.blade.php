@extends('public-part.auth.layout.auth-layout')
<!-- Title -->
@section('title') {{ __('Prijavite se') }} @endsection

<!-- Main section -->
@section('content')
    <div class="auth-form">
        <div class="af-image">
            <img src="{{ asset('files/images/logo.svg') }}" alt="">
        </div>
        <div class="af-form">
            <div class="aff-container">
                <div class="aff-header">
                    <h1 class="tb-color mb-4"> <b>{{ __('Talent Akademija') }}</b> </h1>
                </div>

                <div class="aff-short">
                    <p>
                        {{ __('Unesite Vaš email, te novu korisničku šifru koju želite koristiti. ') }}
                    </p>
                </div>
                <hr>
                <div class="aff-form">
                    <!-- Generated token -->
                    {{ html()->hidden('token')->class('form-control')->value($token) }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email" class="mb-2"> <b> {{ __('Vaš email') }} </b> </label>
                                <input type="email" name="email" class="form-control form-control-sm" id="email" aria-describedby="emailHelp">
                                <small id="emailHelp" class="form-text text-muted"> {{__('Molimo da unesete Vaš email!')}} </small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="mb-2"> <b> {{ __('Vaš šifra') }} </b> </label>
                                <input type="password" name="password" class="form-control form-control-sm" id="password" aria-describedby="passwordHelp">
                                <small id="passwordHelp" class="form-text text-muted"> {{__('Molimo da unesete Vašu šifru!')}} </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="passwordRepeat" class="mb-2"> <b> {{ __('Potvrdite šifru') }} </b> </label>
                                <input type="password" name="passwordRepeat" class="form-control form-control-sm" id="passwordRepeat" aria-describedby="passwordRepeatHelp">
                                <small id="passwordRepeatHelp" class="form-text text-muted"> {{__('Molimo da ponovo unesete željenu šifru radi potvrde!')}} </small>
                            </div>
                        </div>
                    </div>

                    <div class="row aff-links">
                        <!-- It will stay empty for now -->
                        <div class="col-md-6 mt-3 d-inline-flex"> </div>
                        <div class="col-md-6 mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn generate-password-btn"> {{ __('IZMJENA ŠIFRE') }} </button>
                        </div>
                    </div>

                    <hr>

                    <div class="row aff-links mt-3">
                        <p>
                            {{ __('Još nemate korisnički račun?') }}
                            <a href="{{ route('auth.create-account') }}"><b>{{ __('Kreirajte ga ovdje!') }}</b></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
