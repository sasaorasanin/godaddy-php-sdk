<?php

namespace GoDaddy\Services\Domains\v2\Enums;

enum DnssecAlgorithm: string
{
    case RSA_SHA1 = '1';
    case RSA_SHA256 = '8';
    case RSA_SHA512 = '10';
    case ECDSA_P256_SHA256 = '13';
    case ECDSA_P384_SHA384 = '14';
    case ED25519 = '15';
    case ED448 = '16';
} 