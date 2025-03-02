@component('mail::message')

{{ $_name }} se @if($_gender == 1) @if($_what == 'sign_up') prijavio @else odjavio @endif @else @if($_what == 'sign_up') prijavila @else odjavila @endif  @endif @if($_what == 'sign_up') na obuku @else sa obuke @endif <b>{{ $_instance_name }}</b>.

Za više informacija, kliknite <a href="{{ route('system.admin.trainings.instances.submodules.applications', ['instance_id' => $_instance_id ]) }}">ovdje</a>.

@endcomponent
