<?php

use GoDaddy\Services\Domains\v1\DTO\DnsRecordUpdateData;

test('DnsRecordUpdateData returns correct array structure', function () {
    $dnsRecord = new DnsRecordUpdateData(
        data: '192.168.1.1',
        ttl: 3600,
        priority: 10
    );
    
    $result = $dnsRecord->toArray();
    
    expect($result)->toMatchArray([
        'data' => '192.168.1.1',
        'ttl' => 3600,
        'priority' => 10
    ]);
});

test('DnsRecordUpdateData filters null values', function () {
    $dnsRecord = new DnsRecordUpdateData(
        data: '192.168.1.1'
    );
    
    $result = $dnsRecord->toArray();
    
    expect($result)->toMatchArray([
        'data' => '192.168.1.1'
    ]);
});

test('DnsRecordUpdateData fromArray creates correct object', function () {
    $data = [
        'data' => 'mail.example.com',
        'priority' => 10,
        'ttl' => 3600,
        'port' => 25
    ];
    
    $dnsRecord = DnsRecordUpdateData::fromArray($data);
    
    expect($dnsRecord->data)->toBe('mail.example.com');
    expect($dnsRecord->priority)->toBe(10);
    expect($dnsRecord->ttl)->toBe(3600);
    expect($dnsRecord->port)->toBe(25);
    expect($dnsRecord->protocol)->toBeNull();
    expect($dnsRecord->service)->toBeNull();
    expect($dnsRecord->weight)->toBeNull();
}); 
