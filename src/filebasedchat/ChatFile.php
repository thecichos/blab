<?php

namespace thecichos\blab\filebasedchat;

class ChatFile extends \thecichos\blab\chat\Chat
{

	protected function save_message(string $message): bool
	{
		$chats = json_decode(file_get_contents("chats.json"), true);
		$chats[$this->handle][] = $message;
		file_put_contents("chats.json", json_encode($chats));
		return true;
	}

	protected function read_message(): string
	{
		return "";
	}
}