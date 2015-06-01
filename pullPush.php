<?php
echo shell_exec("/usr/bin/git commit");
echo 1;
echo shell_exec("/usr/bin/git pull https://mshira:shira6847@github.com/ramiflam/xmatchge");
echo 2;
echo shell_exec("/usr/bin/git push https://mshira:shira6847@github.com/ramiflam/xmatchge");
echo 3;
?>