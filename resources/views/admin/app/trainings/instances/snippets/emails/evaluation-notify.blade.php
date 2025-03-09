@component('mail::message')

@if($_gender == 1) Poštovani @else Poštovana @endif {{ $_name }},

Objavljena je evaluacija za obuku "<i>{{ $_instance_title }}</i>". Molimo Vas da istu popunite pute <a href="{{ route('system.user-data.trainings.preview', ['id' => $_instance_id ]) }}">ovog linka</a>.

@endcomponent
