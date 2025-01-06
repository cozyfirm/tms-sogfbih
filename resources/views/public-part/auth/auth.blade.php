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
                    <h1 class="tb-color mb-4"> <b>{{ __('SOGFBiH') }}</b> </h1>
                </div>

                <div class="aff-short">
                    <p>
                        {{ __('Dobrodošli nazad. Unesite Vaše kredencijale i prijavite se na sistem www.example.ba. Enjoy using it !') }}
                    </p>
                </div>
                <hr>
                <div class="aff-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="mb-2"> <b> {{ __('Vaš email') }} </b> </label>
                                <input type="email" name="email" class="form-control form-control-sm mb-2" id="email" aria-describedby="emailHelp">
                                <small id="emailHelp" class="form-text text-muted"> {{__('Molimo da unesete Vaš email!')}} </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="mb-2"> <b> {{ __('Vaša šifra / lozinka') }} </b> </label>
                                <input type="password" name="password" class="form-control form-control-sm mb-2" id="password" aria-describedby="passwordHelp">
                                <small id="passwordHelp" class="form-text text-muted"> {{ __('Vaša korisnička šifra / lozinka') }} </small>
                            </div>
                        </div>
                    </div>

                    <div class="row aff-links">
                        <div class="col-md-6 mt-3 aff-links-left-links">
                            <div class="stay-logged-in">
                                <input type="checkbox" name="stay_logged" id="stay_logged">
                                <label for="stay_logged">{{ __('Ostanite prijavljeni') }}</label>
                            </div>
                            <span>|</span>
                            <a href="{{ route('auth.restart-password') }}"> {{ __('Zaboravili ste šifru?') }} </a>
                        </div>
                        <div class="col-md-6 mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn auth-btn"> {{ __('PRIJAVITE SE') }} </button>
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
