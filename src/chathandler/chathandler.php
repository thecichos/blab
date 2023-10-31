<?php

namespace thecichos\blab\chathandler;

use thecichos\blab\SocketeerIntermediate\SocketeerIntermediate;

abstract class chathandler extends SocketeerIntermediate
{

	/**
	 * This method is used to evaluate if the user is allowed to create a new chat
	 * @param array $data
	 * @return boolean
	 */
	abstract protected function is_allowed_to_create_chat(array $data) : bool;

	/**
	 * This method is used to create a chat
	 * @param array $data
	 * @return bool
	 */
	abstract protected function create_chat(array $data) : bool;

	/**
	 * @param array $data
	 * @return mixed
	 */
	abstract protected function close(array $data);

	/**
	 * This method can be used to return what chats the user is allowed to see
	 * @return array
	 */
	abstract protected function handle_heartbeat() : array;

	const 			cycle_check = 100;
	private int		$cycle = 0;
	private array	$heartbeat = ["md5" => "", "age" => 0];

	public function __construct(string $handle, int $port, string $hostName, int $log = 0)
	{
		error_log("start");
		parent::__construct($handle, $port, $hostName, $log);
	}

	/**
	 * @inheritDoc
	 */
	protected function connect_socket($socket): bool
	{
		return true;
	}

	/**
	 * @inheritDoc
	 */
	protected function socket_receive($socketData, $socketResource): bool
	{
		$data = json_decode($this->unseal($socketData), true);
		if (!$data) return false;

		if (!isset($data["action"])) {
			$this->write_to_single_socket(
				$socketResource,
				json_encode(["error" => true, "error_code" => "Invalid command"])
			);
			return false;
		}

		switch ($data["action"]) {
			case "create":
				if ($this->is_allowed_to_create_chat($data["data"])) {
					$this->create_chat($data["data"]);
				}
				break;
			case "close_server":
				$this->close($data["data"]);
				break;
			case "heartbeat":

				$this->write_to_single_socket(
					$socketResource,
					json_encode($this->handle_heartbeat())
				);
				break;
			default:
				$this->write_to_single_socket(
					$socketResource,
					json_encode(["error" => true, "error_code" => "Invalid command"])
				);
				break;
		}

		return true;
	}

	/**
	 * @inheritDoc
	 */
	protected function on_socket_disconnect(): bool
	{
		return true;
	}

	/**
	 * @inheritDoc
	 */
	protected function cycle_check(): void
	{

		if ($this->cycle !== chathandler::cycle_check) {
			$this->cycle = 0;
			return;
		}

		/** Update the internal chat array */

		$heartbeat = md5(json_encode($this->handle_heartbeat()));

		if ($heartbeat === $this->heartbeat["md5"]) {
			$this->heartbeat["age"]++;
		} else {
			$this->heartbeat = ["md5" => $heartbeat, "age" => 0];
		}



		$this->cycle++;
	}

	/**
	 * @inheritDoc
	 */
	protected function is_alive(): bool
	{
		return $this->heartbeat["age"] < 200;
	}

	/**
	 * @inheritDoc
	 */
	protected function cleanup(): void
	{
		// TODO: Implement cleanup() method.
	}

}