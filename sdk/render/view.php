<?php
declare(strict_types=1);

namespace sdk\render;

use Exception;

final class view
{
	private static ?string $default_path = null;
	private string $name;

	public function __construct(string $name, ?string $default_path = null)
	{
		if (self::$default_path === null) {
			throw new Exception('view default path must be set');
		}

		$this->name = $name;
	}

	public static function set_default_path(string $path)
	{
		self::$default_path = $path;
	}

	public function render()
	{
		require self::$default_path . $this->name;
	}

	public function get_content(): string
	{
		return file_get_contents(self::$default_path . $this->name);
	}
}
