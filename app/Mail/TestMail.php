<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Parameter;

class TestMail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
			//
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$title = Parameter::key('branding_title');
		return $this->subject(
			'[' . config('app.name', 'StundenCheck') . ' - ' . $title . '] Test E-Mail'
		)->view('mail.test-email', ['title' => $title]);
	}
}
