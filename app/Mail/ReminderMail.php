<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Parameter;
use App\Models\User;

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
		$account       = $this->user->account;
		$separate      = $account->separate_accounting;
		$start         = Parameter::cycleStart();
		$cycle_missing = $separate ? $this->user->missingHoursByCycle($start) : $account->missingHoursByCycle($start);
		$cycle_sum     = $separate ? $this->user->sumHoursByCycle($start)     : $account->sumHoursByCycle($start);
		$cycle_target  = $separate ? $this->user->totalHoursByCycle($start)   : $account->totalHoursByCycle($start);
		return $this->subject(
			'[' . config('app.name', 'StundenCheck') . ' - ' . $title . '] Erinnerung Stunden eintragen'
		)->view('mail.reminder-email', [
			'title'         => $title,
			'tasksurl'      => Parameter::key('tasks_url'),
			'user'          => $this->user,
			'cycle_missing' => $cycle_missing >= 0 ? round($cycle_missing, 1) : 0,
			'cycle_sum'     => round($cycle_sum, 1),
			'cycle_target'  => round($cycle_target, 1),
			'cycle_end'     => Parameter::cycleEnd()->isoFormat('LL'),
		]);
	}

	public static function demoData()
	{
		return [
			'title'         => Parameter::key('branding_title'),
			'tasksurl'      => Parameter::key('tasks_url'),
			'user'          => User::factory()->state(['firstname' => fake()->firstName(), 'lastname' => fake()->lastName()])->make(),
			'cycle_missing' => 8,
			'cycle_sum'     => 16,
			'cycle_target'  => 24,
			'cycle_end'     => Parameter::cycleEnd()->isoFormat('LL'),
		];
	}
}
