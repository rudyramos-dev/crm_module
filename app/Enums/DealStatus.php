<?php

declare(strict_types=1);

namespace App\Enums;

enum DealStatus: string
{
    case Active = 'active';
    case Won = 'won';
    case Lost = 'lost';
}
