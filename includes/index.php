<?php
$brick = Brick::$builder->brick;

$user = Abricos::$user->info;

$unm = $user['username'];
$lnm = $user['lastname'];
$fnm = $user['firstname'];

$username = empty($lnm) && empty($fnm) ? $unm : $fnm."&nbsp;".$lnm;

$brick->content = Brick::ReplaceVarByData($brick->content, array(
	"userid" => $user['userid'],
	"username" => $username
));
 
?>