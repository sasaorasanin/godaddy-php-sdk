<?php

namespace GoDaddy\Services\Domains\v1\Enums;

enum CheckType: string
{
    case FAST = 'FAST';
    case FULL = 'FULL';
    case FAST_LOWERCASE = 'fast';
    case FULL_LOWERCASE = 'full';
} 