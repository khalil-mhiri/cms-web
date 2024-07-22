<?php
date_default timezone_set("Asia/Karachi");
$CurrentTime-time();
$DateTime-strftime("%8-%d-%Y %H:%M:%S", $CurrentTime);
echo $DateTime;
?>