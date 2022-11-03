<div class="flex gap-4 mt-4">
	<div class="w-1/2">
		<!-- new password first -->
		<x-text-input
			class="block w-full"
			type="password"
			name="newpass"
			:label="__('Neues Passwort')"
			:info="__('Das Passwort muss mindestens 8 Zeichen lang sein und Kleinbuchstaben, Großbuchstaben und Zahlen enthalten.')"
			required
			autofocus
		/>
	</div>
	<div class="w-1/2">
		<!-- new password second -->
		<x-text-input
			class="block w-full"
			type="password"
			name="newpass_confirmation"
			:label="__('Passwort wiederholen')"
			required
			autofocus
		/>
	</div>
</div>
<div class="flex gap-4 mt-4">
	<div class="w-1/2">
		<!-- old password -->
		<x-text-input
			class="block w-full"
			type="password"
			name="pass"
			:label="__('Aktuelles Passwort')"
			:info="__('Gib zur Bestätigung ein letztes Mal dein aktuelles Passwort an.')"
			required
			autofocus
		/>
	</div>
	<div class="w-1/2">
	</div>
</div>
