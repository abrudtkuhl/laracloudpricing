<?php

use App\Services\PricingService;

beforeEach(function () {
    $this->pricingService = new PricingService();
});

it('calculates kv cost for 1gb tier', function () {
    $tier = '1gb';
    $expectedCost = 20.00;
    $actualCost = $this->pricingService->calculateKvCost($tier);
    expect($actualCost)->toBe($expectedCost);
});

it('calculates kv cost for 5gb tier', function () {
    $tier = '5gb';
    $expectedCost = 77.00;
    $actualCost = $this->pricingService->calculateKvCost($tier);
    expect($actualCost)->toBe($expectedCost);
});

it('calculates kv cost for highest tier', function () {
    $tier = '100gb';
    $expectedCost = 680.00;
    $actualCost = $this->pricingService->calculateKvCost($tier);
    expect($actualCost)->toBe($expectedCost);
});

it('returns zero for unknown kv tier', function () {
    $tier = 'unknown_tier';
    $expectedCost = 0.00;
    $actualCost = $this->pricingService->calculateKvCost($tier);
    expect($actualCost)->toBe($expectedCost);
}); 