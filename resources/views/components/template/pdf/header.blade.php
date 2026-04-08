@props([
    'subject'     => 'Document Title',
    'description'  => 'Department Name',
    'ref'       => 'N/A',
    'email'     => null,
    'phones'    => [],
    'taxNumber' => null,
])

<div class="pdf-header">

    <div class="pdf-header__row">

        <div class="pdf-header__accent"></div>

        <div class="pdf-header__content">

            {{-- Brand --}}
            <div class="pdf-header__brand">
                <div class="pdf-header__logo-box">
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Logo"
                        class="pdf-header__logo-img"
                    >
                </div>
                <div>
                    <p class="pdf-header__company-name">{{ config('app.name') }}</p>
                    <p class="pdf-header__company-url">{{ $email }}</p>
                </div>
            </div>

            {{-- Title --}}
            <div class="pdf-header__title-block">
                <p class="pdf-header__title-label">{{ $subject }}</p>
                <div class="pdf-header__title-row">
                    <span class="pdf-header__title-rule"></span>
                    <p class="pdf-header__title-text">{{ $description }}</p>
                    <span class="pdf-header__title-rule"></span>
                </div>
            </div>

            {{-- Ref --}}
            <div class="pdf-header__meta">
                <div class="pdf-header__meta-row">
                    <span class="pdf-header__meta-label">Ref</span>
                    <span class="pdf-header__meta-badge">{{ $ref }}</span>
                </div>
            </div>

        </div>
    </div>

    {{-- Divider --}}
    <div class="pdf-header__divider"></div>

    <div class="pdf-header__subbar">
        <div class="pdf-header__subbar-child">
            @if(!empty($phones))
                <span class="pdf-header__subbar-left">
                    Phone — {{ implode(' - ', $phones) }}
                </span>
            @endif

            @if($taxNumber)
                <span class="pdf-header__subbar-left">
                    Tax No.: {{ $taxNumber }}
                </span>
            @endif
        </div>

        <span class="pdf-header__subbar-right">
            {{ now()->format('d M Y h:i A') }}
        </span>
    </div>

</div>