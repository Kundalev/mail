<?php
use App\DB;
require 'vendor/autoload.php';

$allMessages = DB::getAll("SELECT * FROM `mails`");
$json = json_encode($allMessages, JSON_UNESCAPED_UNICODE);

file_put_contents('/home/max/www/test3.localhost/public_html/mails.json', $json);

