<?php

declare(strict_types=1);

namespace Montonio\Enums;

enum Environment: string
{
    case Sandbox = 'sandbox';
    case Live = 'live';
}
