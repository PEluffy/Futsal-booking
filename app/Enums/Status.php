<?php

namespace App\Enums;

enum Status: string
{
    case Reserved = 'reserved';
    case Booked = 'booked';
    case Canceled = 'canceled';
}
