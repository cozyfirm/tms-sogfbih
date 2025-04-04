<div class="preview__gallery d-none">
    <div class="gallery__header">
        <div class="left__side">
            <p> <span class="current-index no-select">1</span> / <span class="total-images no-select">{{ $images->count() }}</span> </p>
        </div>
        <div class="right__side">
{{--            <img class="download-icon no-select" src="{{ asset('files/images/icons/cloud-arrow-down-solid.svg') }}" alt="{{ __('Close icon') }}" title="{{ __('Preuzmite fotografiju') }}">--}}

            <img class="close-preview-gallery no-select" src="{{ asset('files/images/icons/cross-small-white.svg') }}" alt="{{ __('Close icon') }}" title="{{ __('Zatvorite skočni prozor') }}">
        </div>
    </div>

    <div class="gi__middle__wrapper">
        <div class="left-arrow-wrapper">
            <div class="law_w previous-img">
                <img src="{{ asset('files/images/icons/arrow-left-solid.svg') }}" class="no-select" alt="{{ __('Arrow icon') }}">
            </div>
        </div>
        <div class="gi__preview">
            @php $index = 1; @endphp
            @foreach($images as $image)
                <img src="{{ asset($image->getFile()) }}" alt="{{ __('Gallery file') }}" class="gallery-huge-image no-select @if($index == 1) active @endif" index="{{ $index++ }}">
            @endforeach
        </div>
        <div class="right-arrow-wrapper">
            <div class="law_w next-img">
                <img src="{{ asset('files/images/icons/arrow-right-solid.svg') }}" class="no-select" alt="{{ __('Arrow icon') }}">
            </div>
        </div>
    </div>

    <div class="gallery__footer">
        <div class="inner__wrapper">
            @php $index = 1; @endphp
            @foreach($images as $image)
                <div class="image__wrapper @if($index == 1) active @endif" index="{{ $index++ }}">
                    <img src="{{ asset($image->getFile()) }}" alt="{{ __('Gallery file') }}" class="gallery-small-image no-select">
                </div>
            @endforeach
        </div>
    </div>
</div>
