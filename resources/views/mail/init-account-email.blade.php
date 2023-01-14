<p>Hallo {{ $user->firstname }} {{ $user->lastname }},</p>
<p>es wurde soeben ein {{ config('app.name', 'StundenCheck') }} Benutzerkonto für dich angelegt. Du hast nun die Möglichkeit, die von dir geleisteten Stunden zu registrieren.</p>
<p>Du erreichst die {{ config('app.name', 'StundenCheck') }} Webanwendung unter dieser Adresse:<br>{{ config('app.url') }}</p>
<p>Das sind deine Anmeldedaten:</p>
<pre>
{{ $user->email }}
{{ $pass }}
</pre>
<p>Bitte ändere dein Passwort beim ersten Login. Falls du Fragen hast oder Probleme mit der Anwendung, kontaktiere uns gern unter {{ config('mail.from.address') }}</p>
<p>Dein {{ config('app.name', 'StundenCheck') }} Team<br>{{ $title }}</p>
