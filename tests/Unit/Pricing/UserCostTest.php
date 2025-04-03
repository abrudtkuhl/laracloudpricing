<?php

use App\Services\PricingService;

beforeEach(function () {
    $this->pricingService = new PricingService();
});

it('calculates users cost for production plan with additional users', function () {
    $plan = 'production';
    $additionalUsers = 5;
    $pricePerUser = 10.00;
    $expectedCost = $additionalUsers * $pricePerUser; // 50.00

    $actualCost = $this->pricingService->calculateUsersCost($plan, $additionalUsers);
    expect($actualCost)->toBe($expectedCost);
});

it('calculates users cost for business plan with additional users', function () {
    $plan = 'business';
    $additionalUsers = 15;
    $pricePerUser = 10.00;
    $expectedCost = $additionalUsers * $pricePerUser; // 150.00

    $actualCost = $this->pricingService->calculateUsersCost($plan, $additionalUsers);
    expect($actualCost)->toBe($expectedCost);
});

it('calculates zero users cost for production plan with zero additional users', function () {
    $plan = 'production';
    $additionalUsers = 0;
    $expectedCost = 0.00;

    $actualCost = $this->pricingService->calculateUsersCost($plan, $additionalUsers);
    expect($actualCost)->toBe($expectedCost);
});

it('calculates zero users cost for sandbox plan regardless of additional users', function () {
    $plan = 'sandbox';
    $additionalUsers = 10; // Should be ignored
    $expectedCost = 0.00;

    $actualCost = $this->pricingService->calculateUsersCost($plan, $additionalUsers);
    expect($actualCost)->toBe($expectedCost);
}); 