<?php

use App\Services\PricingService;

beforeEach(function () {
    $this->pricingService = new PricingService();
});

it('calculates base plan cost for sandbox', function () {
    $plan = 'sandbox';
    $expectedCost = 0.00;
    $actualCost = $this->pricingService->calculateBasePlanCost($plan);
    expect($actualCost)->toBe($expectedCost);
});

it('calculates base plan cost for production', function () {
    $plan = 'production';
    $expectedCost = 20.00;
    $actualCost = $this->pricingService->calculateBasePlanCost($plan);
    expect($actualCost)->toBe($expectedCost);
});

it('calculates base plan cost for business', function () {
    $plan = 'business';
    $expectedCost = 200.00;
    $actualCost = $this->pricingService->calculateBasePlanCost($plan);
    expect($actualCost)->toBe($expectedCost);
});

it('returns zero for unknown plan', function () {
    $plan = 'unknown_plan';
    $expectedCost = 0.00;
    $actualCost = $this->pricingService->calculateBasePlanCost($plan);
    expect($actualCost)->toBe($expectedCost);
}); 