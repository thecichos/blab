<?php
#
#	THIS FILE IS AN EXAMPLE OF HOW TO CREATE A CHAT AND CHATHANDLER
#
#	THE CONSTANTS "PHP_COMMAND" AND "PHP_CHAT_HOST" MUST BE SET
#

$path = __DIR__;

$path = preg_replace("/\\\\/", "/", $path);
error_reporting(E_ALL);
ini_set("error_log", $path."/php_errors_log.log");

if (isset($argv)) {
	include end($argv);
}

if (!defined("PHP_COMMAND")) {
	error_log("Constant PHP_COMMAND not set");
	die("Constant PHP_COMMAND not set");
}
if (!defined("PHP_CHAT_HOST")) {
	error_log("Constant CHAT_HOST not set");
	die("Constant CHAT_HOST not set");
}
if (!defined("CONSTANT_FILE_PATH")) {
	error_log("Constant CONSTANT_FILE_PATH not set");
	die("Constant CONSTANT_FILE_PATH not set");
}

if (isset($_GET["method"])) {
	if ($_GET["method"] === "external_start") {
		$command = PHP_COMMAND." -q ".$path."/controlstructure.php start_handler ".CONSTANT_FILE_PATH;
		pclose(popen($command, "r"));
	}
}

if (isset($argv)) {
	include dirname(__FILE__)."/../../vendor/autoload.php";
	if ($argv[1] === "start_handler") {
		new \thecichos\blab\filebasedchat\ChatHandlerFile("chathandler", 5690, PHP_CHAT_HOST, 3);
	}
	if ($argv[1] === "start_chat") {
		new \thecichos\blab\filebasedchat\ChatFile($argv[2], $argv[3], PHP_CHAT_HOST);
	}
}