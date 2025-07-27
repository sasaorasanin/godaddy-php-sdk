<?php

namespace GoDaddy\Services\Domains\v2\Enums;

enum DomainInclude: string
{
    case ACTIONS = 'actions';
    case CONTACTS = 'contacts';
    case DNSSEC_RECORDS = 'dnssecRecords';
    case REGISTRY_STATUS_CODES = 'registryStatusCodes';
} 