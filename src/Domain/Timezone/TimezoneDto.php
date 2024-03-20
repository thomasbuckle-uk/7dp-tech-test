<?php

declare(strict_types=1);

namespace Domain\Timezone;

final class TimezoneDto
{

    public string $timezone;

    public int $tzOffsetMinutes;

    public int $febDaysInMonth;

    public string $month;

    public int $userDaysInMonth;

    public function __construct(
        string $timezone,
        int    $tzOffsetMinutes,
        int    $febDaysInMonth,
        string $month,
        int    $userDaysInMonth
    )
    {
        $this->timezone = $timezone;
        $this->tzOffsetMinutes = $tzOffsetMinutes;
        $this->febDaysInMonth = $febDaysInMonth;
        $this->month = $month;
        $this->userDaysInMonth = $userDaysInMonth;
    }

}