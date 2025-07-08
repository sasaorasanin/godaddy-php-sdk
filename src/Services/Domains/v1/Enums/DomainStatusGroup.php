<?php

namespace GoDaddy\Services\Domains\v1\Enums;

enum DomainStatusGroup: string
{
    case INACTIVE = 'INACTIVE';
    case PRE_REGISTRATION = 'PRE_REGISTRATION';
    case REDEMPTION = 'REDEMPTION';
    case RENEWABLE = 'RENEWABLE';
    case VERIFICATION_ICANN = 'VERIFICATION_ICANN';
    case VISIBLE = 'VISIBLE';
} 