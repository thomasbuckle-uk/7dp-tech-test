<?php

declare(strict_types=1);

namespace Domain\Timezone;

use DateTime;

final class TimezoneFormRequestDto
{
    public DateTime $date;

    public string $timezone;


    public function __construct(
        DateTime $date,
        string   $timezone
    )
    {
        $this->date = $date;
        $this->timezone = $timezone;
    }
}