<?php

// PHP_Bybazz
// exec, shell_exec, passthru, system, pcntl_exec, proc_open, fread/popen

function ex($command)
{
	$func = ['shell_exec', 'passthru', 'system', 'exec'];

	foreach ($func as $value)
	{
		if (function_exists($value) && $value != 'exec')
		{
			return $value($command);
		}
		elseif (function_exists($value) && $value == 'exec')
		{
			exec($command, $text);

			foreach ($text as $value)
			{
				$output[] = $value;
			}

			return implode('', $output);
		}
	}

	if (function_exists('pcntl_exec'))
	{
		return pcntl_exec('/bin/bash', ['-c', $command]);
	}

	if (function_exists('proc_open'))
	{
		return proc_close(proc_open($command, [], $something));
	}

	if (function_exists('fread') && function_exists('popen'))
	{
		if (strstr($command, '&&'))
		{
			$arr = explode('&&', $command);

			foreach ($arr as $value)
			{
				$output[] = fread(popen('/bin/' . trim($value), 'r'), 4096);
			}

			return implode('', $output);
		}
		else
		{
			return fread(popen('/bin/' . $command, 'r'), 4096);
		}
	}
}

echo ex('uname -a');

?>