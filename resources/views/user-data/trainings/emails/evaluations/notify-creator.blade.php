@component('mail::message')

{{ $_name }} @if($_gender == 1) je završio @else je završila @endif evaluaciju za obuku "<i>{{ $_instance_title }}</i>".

Za više informacija, kliknite <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $_instance_id ]) }}">ovdje</a>.

@endcomponent
