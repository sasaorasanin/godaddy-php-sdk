<?php

namespace GoDaddy\Services\Domains\v2\Enums;

enum NotificationType: string
{
    case DOMAIN_EXPIRY = 'DOMAIN_EXPIRY';
    case DOMAIN_TRANSFER = 'DOMAIN_TRANSFER';
    case DOMAIN_RENEWAL = 'DOMAIN_RENEWAL';
    case DOMAIN_REGISTRATION = 'DOMAIN_REGISTRATION';
} 