<?php
header('Access-Control-Allow-Origin: *');

class LogBook{
    public $week="";
    public $date="";
    public $day = "";
    public $log="";
}

$data = array();

$logbook = new LogBook();
$logbook->week = "1";
$logbook->date = "7-10-2020";
$logbook->day = "Wednesday";
$logbook->log = "Briefing";
array_push($data, $logbook);

echo json_encode($data);
?>