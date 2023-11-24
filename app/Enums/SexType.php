<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class SexType extends Enum
{
    const NOT_KNOWN = 'not_known';
    const MALE = 'male';
    const FEMALE = 'female';
}
