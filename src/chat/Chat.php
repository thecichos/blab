<?php

namespace thecichos\blab\chat;

use thecichos\blab\SocketeerIntermediate\SocketeerIntermediate;

abstract class Chat extends SocketeerIntermediate
{

	abstract protected function save_message(string $message): bool;
	abstract protected function read_message(): string;

	public function __construct(string $handle, int $port, string $hostName, int $log = 0)
	{
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
			case "write":
				break;
			case "read":
				break;
			case "heartbeat":
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
		// TODO: Implement cycle_check() method.
	}

	/**
	 * @inheritDoc
	 */
	protected function is_alive(): bool
	{
		return true;
	}

	/**
	 * @inheritDoc
	 */
	protected function cleanup(): void
	{

	}

}