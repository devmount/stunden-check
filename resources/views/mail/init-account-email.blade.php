<p>Hallo {{ $user->firstname }} {{ $user->lastname }},</p>
<p>es wurde soeben ein StundenCheck Benutzerkonto für dich angelegt. Du hast nun die Möglichkeit, die von dir geleisteten Stunden zu registrieren.</p>
<p>Du erreichst die StundenCheck Webanwendung unter dieser Adresse:<br>{{ env('APP_URL') }}</p>
<p>Das sind deine Anmeldedaten:</p>
<pre>
{{ $user->email }}
{{ $pass }}
</pre>
<p>Bitte ändere dein Passwort beim ersten Login. Falls du Fragen hast oder Probleme mit der Anwendung, kontaktiere uns gern unter {{ env('MAIL_FROM_ADDRESS') }}</p>
<p>Dein StundenCheck Team</p>
