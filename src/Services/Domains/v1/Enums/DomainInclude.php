<?php

namespace GoDaddy\Services\Domains\v1\Enums;

enum DomainInclude: string
{
    case AUTH_CODE = 'authCode';
    case CONTACTS = 'contacts';
    case NAME_SERVERS = 'nameServers';
} 