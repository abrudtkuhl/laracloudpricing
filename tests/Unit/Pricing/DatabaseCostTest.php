<?php

use App\Services\PricingService;

beforeEach(function () {
    $this->pricingService = new PricingService();
});

test('database cost is zero when type is none', function () {
    $cost = $this->pricingService->calculateDatabaseCost('none', null, null, 10);
    expect($cost)->toBe(0.00);
});

// MySQL Tests
it('calculates mysql cost with specific size and storage', function () {
    // mysql-flex-1c-1g: 10.95 / month compute
    // storage: 0.20 / GB-month
    $dbType = 'mysql';
    $mysqlSizeKey = 'mysql-flex-1c-1g';
    $postgresCpuUnits = null;
    $storageGB = 50;

    $expectedComputeCost = 10.95;
    $expectedStorageCost = 50 * 0.20;
    $expectedTotalCost = $expectedComputeCost + $expectedStorageCost; // 10.95 + 10.00 = 20.95

    $actualCost = $this->pricingService->calculateDatabaseCost($dbType, $mysqlSizeKey, $postgresCpuUnits, $storageGB);
    expect($actualCost)->toBe($expectedTotalCost);
});

it('calculates mysql cost with minimum storage', function () {
    $dbType = 'mysql';
    $mysqlSizeKey = 'mysql-flex-1c-512m'; // 5.47 compute
    $postgresCpuUnits = null;
    $storageGB = 1;

    $expectedComputeCost = 5.47;
    $expectedStorageCost = 1 * 0.20;
    $expectedTotalCost = $expectedComputeCost + $expectedStorageCost; // 5.47 + 0.20 = 5.67

    $actualCost = $this->pricingService->calculateDatabaseCost($dbType, $mysqlSizeKey, $postgresCpuUnits, $storageGB);
    expect($actualCost)->toBe($expectedTotalCost);
});

it('returns zero for mysql if size key is invalid', function () {
    $cost = $this->pricingService->calculateDatabaseCost('mysql', 'invalid-key', null, 10);
    expect($cost)->toBe(0.00);
});

it('returns zero for mysql if size key is null', function () {
    $cost = $this->pricingService->calculateDatabaseCost('mysql', null, null, 10);
    expect($cost)->toBe(0.00);
});

// Postgres Tests
it('calculates postgres cost with specific cpu and storage', function () {
    // cpu: 0.16 / hour
    // storage: 1.50 / GB-month
    // hours/month: 730 (from config)
    $dbType = 'postgres';
    $mysqlSizeKey = null;
    $postgresCpuUnits = 0.5;
    $storageGB = 100;

    $expectedComputeCost = 0.5 * 0.16 * 730; // 58.40
    $expectedStorageCost = 100 * 1.50; // 150.00
    $expectedTotalCost = $expectedComputeCost + $expectedStorageCost; // 58.40 + 150.00 = 208.40

    $actualCost = $this->pricingService->calculateDatabaseCost($dbType, $mysqlSizeKey, $postgresCpuUnits, $storageGB);
    expect($actualCost)->toBe($expectedTotalCost);
});

it('calculates postgres cost using minimum cpu if provided value is lower', function () {
    $dbType = 'postgres';
    $mysqlSizeKey = null;
    $postgresCpuUnits = 0.1; // Lower than min (0.25)
    $storageGB = 20;
    $minCpu = 0.25;

    $expectedComputeCost = $minCpu * 0.16 * 730; // 0.25 * 0.16 * 730 = 29.20
    $expectedStorageCost = 20 * 1.50; // 30.00
    $expectedTotalCost = $expectedComputeCost + $expectedStorageCost; // 29.20 + 30.00 = 59.20

    $actualCost = $this->pricingService->calculateDatabaseCost($dbType, $mysqlSizeKey, $postgresCpuUnits, $storageGB);
    expect($actualCost)->toBe($expectedTotalCost);
});

it('calculates postgres cost with minimum storage', function () {
    $dbType = 'postgres';
    $mysqlSizeKey = null;
    $postgresCpuUnits = 1.0;
    $storageGB = 1;

    $expectedComputeCost = 1.0 * 0.16 * 730; // 116.80
    $expectedStorageCost = 1 * 1.50; // 1.50
    $expectedTotalCost = $expectedComputeCost + $expectedStorageCost; // 116.80 + 1.50 = 118.30

    $actualCost = $this->pricingService->calculateDatabaseCost($dbType, $mysqlSizeKey, $postgresCpuUnits, $storageGB);
    expect($actualCost)->toBe($expectedTotalCost);
});

it('returns zero for postgres if cpu units is null', function () {
    $cost = $this->pricingService->calculateDatabaseCost('postgres', null, null, 10);
    expect($cost)->toBe(0.00);
}); 