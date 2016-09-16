<?php

down vote
try this (if your server is Linux):

$command="/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'";
$localIP = exec ($command);
echo $localIP;
echo "Hi Hello 121outsource";
?>
