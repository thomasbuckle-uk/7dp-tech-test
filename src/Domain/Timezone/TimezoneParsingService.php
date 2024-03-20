<?php

declare(strict_types=1);

namespace Domain\Timezone;

use DateTime;
use DateTimeZone;
use Exception;

class TimezoneParsingService
{


    /**
     * @throws Exception
     */
    public function parse(TimezoneFormRequestDto $request): TimezoneDto
    {

        $timezone = new DateTimeZone($request->timezone);

        $now = new DateTime('now', $timezone);
        $tzOffsetMinutes = $timezone->getOffset($now) / 60;

        $year = date('Y', $request->date->getTimestamp());
        $month = date('F', $request->date->getTimestamp());
        $febDaysInMonth = cal_days_in_month(CAL_GREGORIAN, 2, (int)$year);
        $userDaysInMonth = cal_days_in_month(CAL_GREGORIAN, (int)$request->date->format('m'), (int)$year);

        return new TimezoneDto($request->timezone, $tzOffsetMinutes, $febDaysInMonth, $month, $userDaysInMonth);
    }
}