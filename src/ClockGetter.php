<?php declare(strict_types = 1);

namespace OriNette\Time;

use Brick\DateTime\Clock;
use Brick\DateTime\Clock\SystemClock;

final class ClockGetter
{

	private static ?Clock $clock = null;

	private function __construct()
	{
		// Static class
	}

	public static function set(Clock $clock): void
	{
		self::$clock = $clock;
	}

	public static function get(): Clock
	{
		if (self::$clock === null) {
			self::$clock = new SystemClock();
		}

		return self::$clock;
	}

}
