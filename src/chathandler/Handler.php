<?php

namespace thecichos\blab\chathandler;

use thecichos\blab\SocketeerIntermediate\SocketeerIntermediate;

class Handler extends SocketeerIntermediate
{

	const 			cycle_check = 100;
	private int		$cycle = 0;
	private array	$chat_array;

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
		$arrData = json_encode($this->unseal($socketData), true);
		if (!$arrData) return false;

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

		if ($this->cycle !== Handler::cycle_check) {
			$this->cycle = 0;
			return;
		}

		/** Update the internal chat array */



		$this->cycle++;
	}

	/**
	 * @inheritDoc
	 */
	protected function is_alive(): bool
	{
		// TODO: Implement is_alive() method.
		return true;
	}

	/**
	 * @inheritDoc
	 */
	protected function cleanup(): void
	{
		// TODO: Implement cleanup() method.
	}

}