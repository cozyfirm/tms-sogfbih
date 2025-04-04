<div class="instance__inner_w">
    <div class="iiw__header" title="{{ __('Agenda obuke') }}">
        <p>{{ __('Agenda obuke') }}</p>
        <a>
            <img src="{{ asset('files/images/icons/calendar-plus-regular-white.svg') }}" alt="{{ __('Add new date') }}">
        </a>
    </div>

        @if($instance->eventsRel->count())
            <table class="table table-bordered mt-3">
                <thead>
                <tr>
                    <th scope="col" class="text-center" width="40px">#</th>
                    <th scope="col">{{ __('Vrsta') }}</th>
                    <th scope="col">{{ __('Lokacija') }}</th>
                    <th scope="col">{{ __('Datum') }}</th>
                    <th scope="col">{{ __('Početak') }}</th>
                    <th scope="col">{{ __('Završetak') }}</th>
                    @if(Auth()->user()->role == 'admin' or Auth()->user()->role == 'moderator')
                        <th scope="col" class="text-center" width="120px">{{ __('Akcije') }}</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @php $counter = 1; @endphp
                @foreach($instance->eventsRel as $event)
                    <tr>
                        <th scope="row" class="text-center">{{ $counter++ }}.</th>
                        <td>{{ $event->typeRel->name ?? '' }}</td>
                        <td class="@if(Auth()->user()->role == 'admin' or Auth()->user()->role == 'moderator') location-info @elseif(Auth()->user()->role == 'trainer') location-trainer-info @else location-user-info @endif hover-yellow-text" location-id="{{ $event->location_id ?? 0 }}" title="{{ __('Više informacija o mjestu događaja') }}">
                            {{ $event->locationRel->title ?? '' }}
                        </td>
                        <td>{{ $event->date() }}</td>
                        <td>{{ $event->tf ?? '' }}h</td>
                        <td>{{ $event->td ?? '' }}h</td>

                        @if(Auth()->user()->role == 'admin' or Auth()->user()->role == 'moderator')
                            <td class="text-center">
                                <a class="table-btn-link fetch-event" event-id="{{ $event->id }}" title="{{ __('Više informacija') }}">
                                    <button class="table-btn">{{ __('Info') }}</button>
                                </a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
</div>
