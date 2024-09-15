<?php

header("Access-Control-Allow-Origin: *");

require "GoogleTranslate.php";
// require "vendor/autoload.php"; // use composer

use GoogleTranslate\GoogleTranslate;

$text= $_GET['text'];
$from = "en";
$to   = "es";

$st = new GoogleTranslate($text, $from, $to);
$result = $st->exec();

echo $result; // How are you?
echo "\n";