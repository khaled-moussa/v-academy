<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		@include('layouts.partials.head')
	</head>

	<body>
		<div class="under-dev-page">
			{{-- Centered content section --}}
			<div class="under-dev-content">

				{{-- Optional pulse --}}
				@hasSection('pulse')
					<span class="under-dev-pulse">
						<span class="dot"></span>
						<span class="dot-shadow"></span>
					</span>
				@endif

				{{-- Page title --}}
				<div class="under-dev-header">
					<h1 class="under-dev-code">@yield('code')</h1>
					<h1 class="under-dev-title">@yield('title')</h1>
				</div>

				{{-- Page message --}}
				<p class="under-dev-subtitle">@yield('message')</p>

				{{-- Optional button --}}
				@hasSection('button')
					<p class="under-dev-button">
						<x-button.link
							class="outline-btn"
							label="Go Home"
							:path="url('/')"
						/>
					</p>
				@endif
			</div>
		</div>
	</body>

</html>
