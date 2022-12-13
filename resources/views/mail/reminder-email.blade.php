<p>
	Hallo {{ $user->firstname }} {{ $user->lastname }},
</p>
<p>
	bitte denk daran, deine Stunden einzutragen.
	@if ($cycle_sum < $cycle_target)
		Für den aktuellen Abrechnungszeitraum sind für dein Konto <b>{{ $cycle_sum }}</b> von <b>{{ $cycle_target }}</b> Stunden registriert.
	@endif
	Insgesamt sind für dein Konto <b>{{ $total_sum }}</b> von <b>{{ $total_target }}</b> Stunden registriert. Es stehen noch <b>{{ $missing }}</b> Stunden aus.
</p>
<p>
	Du erreichst die {{ config('app.name', 'StundenCheck') }} Webanwendung unter dieser Adresse:<br>
	{{ env('APP_URL') }}
</p>
<p>
	Wenn du dein Passwort vergessen hast, kannst du es <a href="{{ url('password.request') }}">hier</a> zurücksetzen.
</p>
<p>
	Du bist noch auf der Suche nach einer passenden Aufgabe? Die Liste aktueller Aufgaben findest du unter <a href="{{ $tasksurl }}">{{ $tasksurl }}</a>.
</p>
<p>
	Falls du Fragen hast oder Probleme mit der Anwendung, kontaktiere uns gern unter {{ env('MAIL_FROM_ADDRESS') }}
</p>
<p>
	Dein {{ config('app.name', 'StundenCheck') }} Team<br>
	{{ $title }}
</p>
