<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'StundenCheck') }}</title>
		<link rel="shortcut icon" type="image/png" href="/favicon.png"/>

		{{-- Fonts --}}
		<link rel="stylesheet" href="https://fonts.bunny.net/css2?family=open-sans:wght@400;600;700&display=swap">

		{{-- Scripts --}}
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>
	<body class="font-sans antialiased bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300">
		<div class="min-h-screen">
			@include('layouts.navigation')

			{{-- Page Header --}}
			<header class="bg-white dark:bg-gray-900 shadow">
				<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
					{{ $header }}
				</div>
			</header>

			{{-- Page Content --}}
			<main>
				{{ $slot }}
			</main>

			{{-- Page Footer --}}
			<footer>
				@include('layouts.credits')
			</footer>

			{{-- Toast Notifications --}}
			@if (session('status'))
				<x-toast>{{ session('status') }}</x-toast>
			@endif
		</div>
	</body>
</html>
