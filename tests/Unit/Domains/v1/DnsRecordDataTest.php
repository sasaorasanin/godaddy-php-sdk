<?php

use GoDaddy\Services\Domains\v1\DTO\DnsRecordData;

test('DnsRecordData returns correct array structure', function () {
    $dnsRecord = new DnsRecordData(
        data: '192.168.1.1',
        name: '@',
        type: 'A',
        ttl: 3600
    );
    
    $result = $dnsRecord->toArray();
    
    expect($result)->toMatchArray([
        'data' => '192.168.1.1',
        'name' => '@',
        'type' => 'A',
        'ttl' => 3600
    ]);
});

test('DnsRecordData filters null values', function () {
    $dnsRecord = new DnsRecordData(
        data: '192.168.1.1',
        name: '@',
        type: 'A'
    );
    
    $result = $dnsRecord->toArray();
    
    expect($result)->toMatchArray([
        'data' => '192.168.1.1',
        'name' => '@',
        'type' => 'A'
    ]);
});

test('DnsRecordData fromArray creates correct object', function () {
    $data = [
        'data' => 'mail.example.com',
        'name' => '@',
        'type' => 'MX',
        'priority' => 10,
        'ttl' => 3600
    ];
    
    $dnsRecord = DnsRecordData::fromArray($data);
    
    expect($dnsRecord->data)->toBe('mail.example.com');
    expect($dnsRecord->name)->toBe('@');
    expect($dnsRecord->type)->toBe('MX');
    expect($dnsRecord->priority)->toBe(10);
    expect($dnsRecord->ttl)->toBe(3600);
    expect($dnsRecord->port)->toBeNull();
    expect($dnsRecord->protocol)->toBeNull();
    expect($dnsRecord->service)->toBeNull();
    expect($dnsRecord->weight)->toBeNull();
}); 
