<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Parameter;

class ReminderMail extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;

	private $user;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($user)
	{
		$this->user = $user;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$title         = Parameter::key('branding_title');
		$tasksurl      = Parameter::key('tasks_url');
		$account       = $this->user->account;
		$separate      = $account->separate_accounting;
		$cycle_missing = $separate ? $this->user->missing_hours_cycle : $account->missing_hours_cycle;
		$cycle_sum     = $separate ? $this->user->sum_hours_cycle     : $account->sum_hours_cycle;
		$cycle_target  = $separate ? $this->user->total_hours_cycle   : $account->total_hours_cycle;
		return $this->subject(
			'[' . config('app.name', 'StundenCheck') . ' - ' . $title . '] Erinnerung Stunden eintragen'
		)->view('mail.reminder-email', [
			'title'         => $title,
			'tasksurl'      => $tasksurl,
			'user'          => $this->user,
			'cycle_missing' => $cycle_missing >= 0 ? round($cycle_missing, 1) : 0,
			'cycle_sum'     => round($cycle_sum, 1),
			'cycle_target'  => round($cycle_target, 1),
		]);
	}
}
