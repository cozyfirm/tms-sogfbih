<div class="instance__inner_w">
    <div class="iiw__header">
        <p>{{ __('Datumi održavanja obuke') }}</p>
        <a href="{{ route('system.admin.trainings.instances.date.add', ['instance_id' => $instance->id ]) }}" title="{{ __('Unesite dodatne datume') }}">
            <img src="{{ asset('files/images/icons/calendar-plus-regular-white.svg') }}" alt="{{ __('Add new date') }}">
        </a>
    </div>

    @if($instance->datesRel->count())
        <table class="table table-bordered mt-3">
            <thead>
            <tr>
                <th scope="col" class="text-center" width="40px">#</th>
                <th scope="col">{{ __('Lokacija') }}</th>
                <th scope="col">{{ __('Datum') }}</th>
                <th scope="col">{{ __('Početka') }}</th>
                <th scope="col">{{ __('Završetak') }}</th>
                <th scope="col" class="text-center" width="120px">{{ __('Akcije') }}</th>
            </tr>
            </thead>
            <tbody>
            @php $counter = 1; @endphp
            @foreach($instance->datesRel as $date)
                <tr>
                    <th scope="row" class="text-center">{{ $counter++ }}.</th>
                    <td>{{ $date->location ?? '' }}</td>
                    <td>{{ $date->date() }}</td>
                    <td>{{ $date->tf ?? '' }}h</td>
                    <td>{{ $date->td ?? '' }}h</td>
                    <td class="text-center">
                        <a class="table-btn-link" href="{{route('system.admin.trainings.instances.date.edit', ['id' => $date->id] )}}" title="{{ __('Više informacija') }}">
                            <button class="table-btn">{{ __('Uredite') }}</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
