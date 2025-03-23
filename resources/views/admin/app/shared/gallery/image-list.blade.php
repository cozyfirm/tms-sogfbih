<div class="content-wrapper preview-content-wrapper">
    <div class="gallery__wrapper">
        @php $index = 1; @endphp
        @foreach($images as $image)
            <div class="image__out_wrapper">
                <div class="image__wrapper iw__open_image" index="{{ $index++ }}" title="{{ __('Pregledajte fotografiju') }}">
                    <img src="{{ asset($image->getFile()) }}" alt="">
                    <div class="btn_wrapper">
                        <p> {{ $title }} </p>
                    </div>
                </div>
                <div class="gallery__text__wrapper">
                    <div class="gtw__left">
                        <div class="gtw__image__wrapper">
                            <p>{{ isset($image->createdBy) ? $image->createdBy->getInitials() : 'JD' }}</p>
                        </div>
                        <div class="text__">
                            <h6>{{ $image->createdBy->name ?? '' }}</h6>
                            <p>{{ $image->createdBy->email ?? '' }}</p>
                        </div>
                    </div>
                    @if(Auth()->user()->isAdmin())
                        <div class="right__part">
                            <div class="views">
                                <a href="{{ route($route, ['id' => $image->id ]) }}" class="prevent-delete" text="{{ __('Jeste li sigurni da želite obrisati ovu fotografiju?') }}" title="{{ __('Obrišite fotografiju') }}">
                                    <img src="{{ asset('files/images/icons/file-pen-solid.svg') }}" alt="{{ __('Icon') }}">
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
