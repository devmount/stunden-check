<p>
	Hallo {{ $user->firstname }} {{ $user->lastname }},
</p>
<p>
	es wurde soeben ein {{ config('app.name', 'StundenCheck') }} Benutzerkonto für dich angelegt.
	Du hast nun die Möglichkeit, die von dir geleisteten Stunden zu registrieren.
</p>
<p>
	Du erreichst die {{ config('app.name', 'StundenCheck') }} Webanwendung unter dieser Adresse:<br>
	<a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
</p>
<p>Das sind deine Anmeldedaten:</p>
<pre>
{{ $user->email }}
{{ $pass }}
</pre>
<p>
	Bitte ändere dein Passwort beim ersten Login.
	Falls du Fragen hast oder Probleme mit der Anwendung, kontaktiere uns gern unter <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>
</p>
<p>Dein {{ config('app.name', 'StundenCheck') }} Team<br>{{ $title }}</p>
