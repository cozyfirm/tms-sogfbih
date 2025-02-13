<div class="notifications__wrapper d-none">
    <div class="notifications__header">
        <h5>{{ __('Obavijesti') }}</h5>
        <img class="close-notifications" src="{{ asset('files/images/icons/cross-small.svg') }}" alt="{{ __('Close icon') }}" title="{{ __('Zatvorite obavijesti') }}">
    </div>

    <div class="line"></div>

    <div class="notifications__body">
        @isset(Auth()->user()->notificationsRel)
            <!-- Check does user have any notifications -->
            @foreach(Auth()->user()->notificationsRel as $notification)
                <!-- Check does user that created notification exists -->
                @isset($notification->fromRel)
                    <div class="not__row_wrapper go-to" link="{{ $notification->uri }}" title="{{ $notification->description ?? '' }}">
                        <div class="icon__wrapper ps-12">
                            <p>{{ $notification->fromRel->getInitials() }}</p>
                        </div>
                        <div class="text__wrapper">
                            <div class="text__data">
                                <p>{{ $notification->text ?? '' }}</p>
                                <span>{{ $notification->createdAt() }}</span>
                            </div>
                            <div class="dots__data">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </div>
                        </div>
                    </div>
                @endisset
            @endforeach
        @endisset

        <div class="not__row_wrapper">
            <div class="icon__wrapper ps-12">
                <img src="{{ asset('files/images/default/sparrow.webp') }}" alt="">
            </div>
            <div class="text__wrapper">
                <div class="text__data" title="{{ __('Nove tehnologije u moderno doba') }}">
                    <p>Jovan Perišić se prijavila na obuku "Nove tehnol.."</p>
                    <span>15. Jan 2025 08:23</span>
                </div>
                <div class="dots__data">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </div>
            </div>
        </div>

        <div class="not__row_wrapper">
            <div class="icon__wrapper ps-12">
                <p>ŠS</p>
            </div>
            <div class="text__wrapper">
                <div class="text__data">
                    <p>Šemsa Suljaković se prijavila na obuku "Obuka za predst.."</p>
                    <span>15. Jan 2025 08:14</span>
                </div>
                <div class="dots__data">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </div>
            </div>
        </div>
    </div>
</div>
