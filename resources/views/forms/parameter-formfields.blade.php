<div class="font-semibold">
	{{ __('Allgemeinen Einstellungen') }}
</div>
<div class="flex flex-col sm:flex-row gap-4 mb-8">
	<div class="sm:w-1/2">
		{{-- branding title --}}
		<x-text-input
			class="mt-4 block w-full"
			type="text"
			name="branding_title"
			:value="old('branding_title', $parameters['branding_title'])"
			:label="__('Branding Titel')"
			:info="__('Name oder Titel deines Vereins oder Gruppe.')"
		/>
	</div>
	<div class="sm:w-1/2">
	</div>
</div>
<div class="mb-4 font-semibold">
	{{ __('Berechnung Soll-Stunden') }}
</div>
<div class="mb-4 border-l-4 p-4 text-amber-900 bg-amber-50 border-amber-200">
	{{ __('Änderungen wirken sich auf die Abrechnung aller bestehender Konten (auch in der Vergangenheit) aus.') }}
</div>
<div class="flex flex-col sm:flex-row gap-4 mb-4">
	<div class="sm:w-1/2">
		{{-- accounting cycle --}}
		<x-select-input
			class="block w-full"
			name="cycle_accounting"
			:label="__('Abrechnungsperiode')"
			:info="__('Regelmäßigkeit, in der sich der Zeitraum der Abrechnung wiederholt.')"
			required
		>
			<option {{ old('cycle_accounting', $parameters['cycle_accounting']) == 'annual' ? 'selected' : '' }}>
				{{ __('Jährlich') }}
			</option>
		</x-select-input>
	</div>
	<div class="sm:w-1/2">
		{{-- accounting start date --}}
		<x-text-input
			class="block w-full"
			type="date"
			name="start_accounting"
			:value="old('start_accounting', $parameters['start_accounting'])"
			:label="__('Start Abrechnungsperiode')"
			:info="__('Beginn einer allgemeinen Abrechnungsperiode. Das Jahr dient nur als Referenz und hat keine Relevanz.')"
			required
		/>
	</div>
</div>
<div class="flex flex-col sm:flex-row gap-4 mb-8">
	<div class="sm:w-1/2">
		{{-- number of target hours --}}
		<x-text-input
			class="block w-full"
			type="number"
			name="target_hours"
			:value="old('target_hours', $parameters['target_hours'])"
			:label="__('Mindestanzahl Pflichtstunden')"
			:info="__('Anzahl zu erbringender Pflichtstunden pro Abrechnungsperiode.')"
			step="0.25"
			min="0.25"
			required
		/>
	</div>
	<div class="sm:w-1/2">
	</div>
</div>
<div class="mb-4 font-semibold">
	{{ __('E-Mail Erinnerung') }}
</div>
<div class="flex flex-col sm:flex-row gap-4 mt-4">
	<div class="sm:w-1/2">
		{{-- cycle of email reminder --}}
		<x-select-input
			class="block w-full"
			name="cycle_reminder"
			:label="__('Turnus Erinnerungs-E-Mails')"
			:info="__('Regelmäßigkeit, in der E-Mails zur Erinnerung versendet werden.')"
			required
		>
			<option {{ old('cycle_reminder', $parameters['cycle_reminder']) == 'monthly' ? 'selected' : '' }}>
				{{ __('Monatlich') }}
			</option>
		</x-select-input>
	</div>
	<div class="sm:w-1/2">
		{{-- start day of email reminder --}}
		<x-select-input
			class="block w-full"
			name="start_reminder"
			:label="__('Tag Erinnerungs-E-Mails')"
			:info="__('Tag an dem E-Mails zur Erinnerung versendet werden.')"
			required
		>
			@foreach ([1,14,28] as $d)
				<option
					value="{{ $d }}"
					{{ old('start_reminder', $parameters['start_reminder']) == $d ? 'selected' : '' }}
				>
					{{ $d }}.
				</option>
			@endforeach
		</x-select-input>
	</div>
</div>
