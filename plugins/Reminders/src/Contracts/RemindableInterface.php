<?php

namespace Reminders\Contracts;


interface RemindableInterface
{
	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail();

}