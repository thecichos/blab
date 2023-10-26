<?php

namespace thecichos\blab\chathandler;

use Thecichos\Socketeer\socketeer;
class Handler extends socketeer
{

	/**
	 * @inheritDoc
	 */
	protected function connect_socket($socket): bool
	{
		// TODO: Implement connect_socket() method.
	}

	/**
	 * @inheritDoc
	 */
	protected function socket_receive($socketData, $socketResource): bool
	{
		// TODO: Implement socket_receive() method.
	}

	/**
	 * @inheritDoc
	 */
	protected function on_socket_disconnect(): bool
	{
		// TODO: Implement on_socket_disconnect() method.
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
		// TODO: Implement is_alive() method.
	}

	/**
	 * @inheritDoc
	 */
	protected function cleanup(): void
	{
		// TODO: Implement cleanup() method.
	}

	/**
	 * @inheritDoc
	 */
	protected function get_host_name(): string
	{
		// TODO: Implement get_host_name() method.
	}
}