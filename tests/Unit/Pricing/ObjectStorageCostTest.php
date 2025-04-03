<?php

use App\Services\PricingService;

beforeEach(function () {
    $this->pricingService = new PricingService();
});

it('calculates object storage cost with storage and operations', function () {
    // storage: 0.02 / GB-month
    // class A: 0.005 / thousand
    // class B: 0.0005 / thousand
    $storageGB = 500;
    $classAOpsThousands = 200;
    $classBOpsThousands = 5000;

    $expectedStorageCost = 500 * 0.02;   // 10.00
    $expectedClassACost = 200 * 0.005;   // 1.00
    $expectedClassBCost = 5000 * 0.0005; // 2.50
    $expectedTotalCost = $expectedStorageCost + $expectedClassACost + $expectedClassBCost; // 13.50

    $actualCost = $this->pricingService->calculateObjectStorageCost($storageGB, $classAOpsThousands, $classBOpsThousands);
    expect($actualCost)->toBe($expectedTotalCost);
});

it('calculates object storage cost with zero storage', function () {
    $storageGB = 0;
    $classAOpsThousands = 100;
    $classBOpsThousands = 1000;

    $expectedStorageCost = 0 * 0.02;      // 0.00
    $expectedClassACost = 100 * 0.005;   // 0.50
    $expectedClassBCost = 1000 * 0.0005; // 0.50
    $expectedTotalCost = $expectedStorageCost + $expectedClassACost + $expectedClassBCost; // 1.00

    $actualCost = $this->pricingService->calculateObjectStorageCost($storageGB, $classAOpsThousands, $classBOpsThousands);
    expect($actualCost)->toBe($expectedTotalCost);
});

it('calculates object storage cost with zero operations', function () {
    $storageGB = 100;
    $classAOpsThousands = 0;
    $classBOpsThousands = 0;

    $expectedStorageCost = 100 * 0.02;   // 2.00
    $expectedClassACost = 0 * 0.005;   // 0.00
    $expectedClassBCost = 0 * 0.0005; // 0.00
    $expectedTotalCost = $expectedStorageCost + $expectedClassACost + $expectedClassBCost; // 2.00

    $actualCost = $this->pricingService->calculateObjectStorageCost($storageGB, $classAOpsThousands, $classBOpsThousands);
    expect($actualCost)->toBe($expectedTotalCost);
});

it('calculates object storage cost with zero for all inputs', function () {
    $actualCost = $this->pricingService->calculateObjectStorageCost(0, 0, 0);
    expect($actualCost)->toBe(0.00);
}); 