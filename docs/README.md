# Nette Time

Clock and timezone configuration for Nette

## Content

- [Setup](#setup)
- [Timezone](#timezone)
- [Clock](#clock)
- [Static clock getter](#static-clock-getter)

## Setup

Install with [Composer](https://getcomposer.org)

```sh
composer require orisai/nette-time
```

Register DI extension

```neon
extensions:
    orisai.time: OriNette\Time\DI\TimeExtension
```

## Timezone

Extension sets php timezone to *UTC*. You are free to change to your preferred timezone, but unless you integrate this
package into an existing application, you shouldn't.
UTC-using apps are easier to host and/or use simultaneously in multiple timezones.

```neon
orisai.time:
    timezone: Europe/Prague
```

## Clock

Extension registers a `Brick\DateTime\Clock` service which provides current time.

```php
use Brick\DateTime\Clock;

class YourService
{

	private Clock $clock;

	public function __construct(Clock $clock)
	{
		$this->clock = $clock;
	}

	public function doSomething(): void
	{
		$currentTime = $this->clock->getTime();
	}

}
```

By default is used `SystemClock` which provides system time, but you can change it to another one for testing purposes.

```neon
services:
    orisai.time.clock:
        # Accepts epoch second (timestamp)
        factory: Brick\DateTime\Clock\FixedClock(Brick\DateTime\Instant(978307200))
```

To learn more about `Clock` and related date and time implementation, check used [brick/date-time](https://github.com/brick/date-time) package.

## Static clock getter

Are you lazy? I am too.

```php
use OriNette\Time\ClockGetter;

$clock = ClockGetter::get();
$time = $clock->getTime();
```
