<?php

use App\Models\ActivityLog;

function flash($message, $level = 'info')
{
	session()->flash('flash_message', $message);
	session()->flash('flash_message_level', $level);
}

// save activity log
function activity_log($user_id, $status = 'success', $log_name = 'Successfull Login', $description = null)
{
	if (!$description) {
		$description = 'Successfully logged in at ' . now();
	}
	ActivityLog::create([
		'user_id' => $user_id,
		'ip_address' => request()->ip(),
		'status' => $status,
		'log_name' => $log_name,
		'description' => $description
	]);
}
