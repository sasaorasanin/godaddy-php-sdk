<?php

namespace GoDaddy\Services\Domains\v1\Enums;

enum DnsRecordType: string
{
    case A = 'A';
    case AAAA = 'AAAA';
    case CNAME = 'CNAME';
    case MX = 'MX';
    case NS = 'NS';
    case SOA = 'SOA';
    case SRV = 'SRV';
    case TXT = 'TXT';
} 