<?php

namespace thecichos\blab\SocketeerIntermediate;

use Thecichos\Socketeer\socketeer;

class SocketeerIntermediate extends socketeer
{

	abstract protected function connect_socket($socket): bool;
	abstract protected function socket_receive(string $socketData, $socketResource): bool;
	abstract protected function on_socket_disconnect(): bool;
	abstract protected function cycle_check(): void;
	abstract protected function is_alive(): bool;
	abstract protected function cleanup(): void;

	private string $hostName;

	public function __construct(string $handle, int $port, string $hostName, int $log = 0)
	{
		$this->hostName = $hostName;

		parent::__construct($handle, $port, $log);
	}

	/**
	 * @inheritDoc
	 */
	protected function get_host_name(): string
	{
		return $this->hostName;
	}
}