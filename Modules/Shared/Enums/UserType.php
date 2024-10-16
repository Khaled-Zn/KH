<?php

namespace Modules\Shared\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserType extends Enum
{
    const verified =   'verified';
    const not_verified = 'verified_not';
    const info_not_completed = 'info_not_completed';
    const info_completed = 'info_completed';

}
