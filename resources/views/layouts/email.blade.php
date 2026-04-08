<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

{{-- layouts/partials/head.blade.php --}}

<head>
    {{-- Meta --}}
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1"
    >

    {{-- Title --}}
    <title>
        @yield('title', config('app.name'))
    </title>

    {{-- Favicon --}}
    <link
        rel="icon"
        href="{{ asset('favicon.ico') }}"
    >

    {{-- Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap"
        rel="stylesheet"
    >

    <style>
        /* -------------------------------
         | Global Reset
         |------------------------------- */
        * {
            box-sizing: border-box;
            text-decoration: none;
        }

        body {
            padding: 20px;
            font-family: Arial, sans-serif;
            color: white !important;
        }

        /* -------------------------------
         | Wrapper
         |------------------------------- */
        .email-wrapper {
            width: 100%;
            margin: auto;
            padding: 25px;
            border-radius: 8px;
            background-color: #000000 !important;
        }

        /* -------------------------------
         | Email Inner Container
         |------------------------------- */
        .email-container {
            width: 100%;
            max-width: 650px;
            min-height: 500px;
            margin: 0 auto;
            padding: 25px !important;
            border-radius: 8px;
            background: #161616 !important;
        }

        .email-container .content {
            line-height: 1.8;
        }

        /* -------------------------------
         | Branding / Header
         |------------------------------- */
        .logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 20px;
        }

        .header {
            margin-bottom: 10px;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
        }

        .sub-header {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        /* -------------------------------
         | Code / OTP Box
         |------------------------------- */
        .code {
            display: inline-block;
            width: 100%;
            margin: 10px 0;
            padding: 12px 20px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            color: #36D7AD !important;
            background-color: #36d7ac4f !important;
        }

        /* -------------------------------
         | Footer
         |------------------------------- */
        .footer {
            max-width: 650px;
            margin: 25px auto !important;
            font-size: 14px;
            color: #bbb !important;
        }

        /* -------------------------------
         | Links & Buttons
         |------------------------------- */
        .link {
            margin-top: 12px;
            font-size: 14px;
            line-height: 1.5;
        }

        .link a {
            display: inline-block;
            margin-top: 12px;
            font-size: 14px;
            line-height: 1.5;
            opacity: 0.8;
            text-decoration: underline !important;
            color: white !important;
        }

        .link a:hover {
            color: #d9d9d9 !important;
        }

        .link-btn {
            margin-bottom: 30px;
            padding: 10px;
            border: none !important;
            border-radius: 10px;
            cursor: pointer !important;
            transition: all 0.3s !important;
            text-decoration: none !important;
            color: #000000;
            background-color: #ffffff;
        }

        .link-btn a {
            width: 100%;
            height: 100%;
            color: #000000;
        }

        .link-btn:hover {
            background-color: #cbcbcb !important;
        }

        /* -------------------------------
         | Responsive Design
         |------------------------------- */
        @media (max-width: 768px) {
            .email-wrapper {
                padding: 15px;
            }

            .email-container {
                padding: 20px;
            }

            .header {
                font-size: 20px;
            }

            .sub-header {
                font-size: 16px;
            }

            .code {
                padding: 10px 15px;
                font-size: 16px;
            }

            .footer {
                padding: 0;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-container">
            {{-- Email Dynamic Content --}}
            @yield('content')
        </div>

        {{-- Footer --}}
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
