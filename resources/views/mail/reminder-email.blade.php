<p>
	Hallo {{ $user->firstname }} {{ $user->lastname }},
</p>
<p>
	bitte denk daran, deine Stunden einzutragen.
	Für den aktuellen Abrechnungszeitraum sind für dein Konto <b>{{ $cycle_sum }}</b> von <b>{{ $cycle_target }}</b> Stunden registriert.
	Es stehen noch <b>{{ $cycle_missing }}</b> Stunden bis zum {{ $cycle_end }} aus.
</p>
<p>
	Du erreichst die {{ config('app.name', 'StundenCheck') }} Webanwendung zum Eintragen der Stunden unter dieser Adresse:<br>
	<a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
</p>
<p>
	Wenn du dein Passwort vergessen hast, kannst du es <a href="{{ url('password.request') }}">hier</a> zurücksetzen.
</p>
@if ($tasksurl)
<p>
	Du bist noch auf der Suche nach einer passenden Aufgabe? Die Liste aktueller Aufgaben findest du unter <a href="{{ $tasksurl }}">{{ $tasksurl }}</a>.
</p>
@endif
<p>
	Falls du Fragen hast oder technische Probleme mit der Anwendung, kontaktiere uns gern unter <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>.
</p>
<p>
	Dein {{ config('app.name', 'StundenCheck') }} Team<br>
	{{ $title }}
</p>
