@component('mail::message')
# Oporavak korisničke šifre

Poštovani/a {{ $_name }},

Sa ovog email-a je kreiran zahtjev za oporavak korisničke šifre. Da biste oporavili Vašu korisničku šifru, molimo Vas da
to učinite putem <a href="{{ route('auth.new-password', ['token' => $_token]) }}">ovog</a> linka.

Napomena: Ukoliko je neko drugi inicirao oporavak šifre u Vaše ime, molimo da nas kontaktirate!

Hvala Vam što koristite naš sistem!
Ugodan ostatak dana,<br>
<a href="{{ env('APP_DOMAIN') }}"> {{ env('APP_NAME') }} </a>
@endcomponent
