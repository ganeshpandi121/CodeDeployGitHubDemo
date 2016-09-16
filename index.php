<?php
function getLocalIp()
{ return gethostbyname(trim(`hostname`)); }
?>

