<?php

function executeCommand($command)
{
	$availableFunctions = ['shell_exec', 'passthru', 'system', 'exec', 'pcntl_exec', 'proc_open', 'popen'];

	foreach ($availableFunctions as $func) {
		if (function_exists($func)) {
			switch ($func) {
				case 'shell_exec':
				case 'passthru':
				case 'system':
					return $func($command);

				case 'exec':
					exec($command, $output);
					return implode("\n", $output);

				case 'pcntl_exec':
					return pcntl_exec('/bin/bash', ['-c', $command]);

				case 'proc_open':
					$process = proc_open($command, [], $pipes);
					if (is_resource($process)) {
						$output = stream_get_contents($pipes[1]);
						proc_close($process);
						return $output;
					}
					break;

				case 'popen':
					$process = popen($command, 'r');
					if ($process) {
						$output = stream_get_contents($process);
						fclose($process);
						return $output;
					}
					break;

				default:
					break;
			}
		}
	}

	return false;
}

echo executeCommand('uname -a');

?>
