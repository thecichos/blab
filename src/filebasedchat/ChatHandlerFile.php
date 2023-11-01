<?php

namespace thecichos\blab\filebasedchat;

class ChatHandlerFile extends \thecichos\blab\chathandler\chathandler
{

	private array $arrChats = [];
	private int $heartBeatFetch = 30;
	private int $heartBeatCycle = 0;

	/**
	 * @inheritDoc
	 */
	protected function is_allowed_to_create_chat(array $data): bool
	{
		return true;
	}

	/**
	 * @inheritDoc
	 */
	protected function create_chat(array $data): bool
	{
		$command = PHP_COMMAND." -q endpoints.php start_chat ".$data["name"]." 5691";
		pclose(popen($command, "r"));

		if (!error_get_last()) {
			$this->arrChats[$data["name"]] = ["port" => 5691, "messages" => []];
		} else {
			error_log(error_get_last());
			return false;
		}

		file_put_contents("chats.json", json_encode($this->arrChats));

		return true;
	}

	/**
	 * @inheritDoc
	 */
	protected function close(array $data)
	{
		// TODO: Implement close() method.
	}

	/**
	 * @inheritDoc
	 */
	protected function handle_heartbeat(): array
	{
		error_log("heartbeat");
		$this->heartBeatCycle++;
		if ($this->heartBeatCycle === $this->heartBeatFetch) {
			$this->arrChats = json_decode(file_get_contents("chats.json", true));
			$this->heartBeatCycle = 0;
		}
		return $this->arrChats;
	}
}