<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InitAccountMail extends Mailable
{
	use Queueable, SerializesModels;

	private $user;
	private $pass;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($user, $pass)
	{
		$this->user = $user;
		$this->pass = $pass;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->subject('Dein Waldläufer StundenCheck Benutzerkonto')
								->view('mail.init-account-email', [
									'user' => $this->user,
									'pass' => $this->pass
								]);
	}
}
