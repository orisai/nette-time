<?php declare(strict_types = 1);

namespace Tests\OriNette\Time\Unit\DI;

use Brick\DateTime\Clock;
use Brick\DateTime\Clock\SystemClock;
use OriNette\DI\Boot\ManualConfigurator;
use Orisai\Exceptions\Logic\InvalidArgument;
use PHPUnit\Framework\TestCase;
use function date_default_timezone_get;
use function date_default_timezone_set;
use function dirname;
use function ini_get;

final class TimeExtensionTest extends TestCase
{

	public function testBasic(): void
	{
		$configurator = new ManualConfigurator(dirname(__DIR__, 3));
		$configurator->setDebugMode(true);
		$configurator->addConfig(__DIR__ . '/config.neon');

		date_default_timezone_set('Europe/Prague');
		self::assertSame('Europe/Prague', date_default_timezone_get());

		$container = $configurator->createContainer();

		self::assertInstanceOf(SystemClock::class, $container->getByType(Clock::class));
		self::assertInstanceOf(SystemClock::class, $container->getService('time.clock'));

		self::assertSame('UTC', date_default_timezone_get());
		self::assertSame('UTC', ini_get('date.timezone'));
	}

	public function testUnknownTimezone(): void
	{
		$configurator = new ManualConfigurator(dirname(__DIR__, 3));
		$configurator->setDebugMode(true);
		$configurator->addConfig(__DIR__ . '/config.invalid.neon');

		$this->expectException(InvalidArgument::class);
		$this->expectExceptionMessage('Timezone unknown/timezone is invalid.');

		$configurator->createContainer();
	}

}
