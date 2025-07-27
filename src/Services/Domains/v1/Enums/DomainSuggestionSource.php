<?php

namespace GoDaddy\Services\Domains\v1\Enums;

enum DomainSuggestionSource: string
{
    case CC_TLD = 'CC_TLD';
    case EXTENSION = 'EXTENSION';
    case KEYWORD_SPIN = 'KEYWORD_SPIN';
    case PREMIUM = 'PREMIUM';
    case CCTLD = 'cctld';
    case EXTENSION_LOWERCASE = 'extension';
    case KEYWORD_SPIN_LOWERCASE = 'keywordspin';
    case PREMIUM_LOWERCASE = 'premium';
} 