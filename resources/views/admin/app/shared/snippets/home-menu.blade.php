<div class="reminders home-right-wrapper">
    <div class="home-right-header">
        <p>{{ __('Posljednje prijave') }}</p>
    </div>
    @foreach($lastApplications as $app)
        <div class="home-right-element go-to" link="{{ route('system.admin.trainings.instances.submodules.applications', ['instance_id' => $app->instance_id ]) }}">
            <b>{{ $app->userRel->name ?? '' }}</b> {{ __('se ') . ((($app->userRel->gender ?? "0") == "1") ? __('prijavio') : __('prijavila')) . __(' na obuku') }} <i>"{{ $app->instanceRel->trainingRel->title ?? '' }}"</i>
        </div>
    @endforeach
</div>

<div class="reminders home-right-wrapper">
    <div class="home-right-header">
        <p> {{__('Brzi linkovi')}} </p>
    </div>
    <div class="home-right-element">
        <a href="https://sogfbih.ba" target="_blank"> {{__('Savez općina i gradova')}} </a>
    </div>
    <div class="home-right-element">
        <a href="https://support.cozyfirm.com" target="_blank"> {{__('CozyFirm Podrška')}} </a>
    </div>
</div>
