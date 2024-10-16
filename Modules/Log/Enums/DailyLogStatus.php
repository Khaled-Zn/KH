<?php

namespace Modules\Log\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DailyLogStatus extends Enum
{
    const HAS_DAILY_LOG = 'HAS_DAILY_LOG';
    const NO_DAILY_LOG_CAN_CREATE = 'NO_DAILY_LOG_CAN_CREATE';
    const NO_DAILY_LOG_CAN_NOT_CREATE = 'NO_DAILY_LOG_CAN_NOT_CREATE';

}
