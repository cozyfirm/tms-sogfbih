@component('mail::message')
@if($_gender == 1) Poštovani @else Poštovana @endif {{ $_name }}, <br>
Vaš korisnički račun za <a href="{{ env('APP_DOMAIN') }}">{{ env('APP_NAME') }}</a> je kreiran.

Pristupni podaci su:

Email adresa: {{ $_email }} <br>
Šifra: {{ $_password }}

Hvala Vam što koristite naš sistem! <br>
Ugodan ostatak dana
@endcomponent
