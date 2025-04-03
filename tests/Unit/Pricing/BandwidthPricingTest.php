<?php

use App\Services\PricingService;

// Use beforeEach to instantiate the service for each test
beforeEach(function () {
    $this->pricingService = new PricingService();
    $this->plan = 'production'; // Default to production for examples
});

it('calculates bandwidth cost for fullstack application scenario', function () {
    // Example: 1M visits, 5 req/visit, 40KB edge/visit, 100KB compute/visit
    // Edge: 40KB * 1M = 40GB
    // Compute: 100KB * 1M = 100GB
    // Total: 140GB
    // Plan Allowance (Production): 100GB
    // Chargeable: 140GB - 100GB = 40GB
    // Cost: 40GB * $0.10/GB = $4

    $totalDataTransferredGB = 140;
    $expectedCost = 4.00;

    $actualCost = $this->pricingService->calculateDataTransferCost($this->plan, $totalDataTransferredGB);

    expect($actualCost)->toBeApproximately($expectedCost, 0.01);
});

it('calculates requests cost for fullstack application scenario', function() {
    // Example: 1M visits, 5 req/visit = 5M requests
    // Plan Allowance (Production): 10M
    // Chargeable: 5M - 10M = 0
    // Cost: $0

    $totalRequestsMillions = 5;
    $expectedCost = 0.00;

    $actualCost = $this->pricingService->calculateRequestsCost($this->plan, $totalRequestsMillions);

    expect($actualCost)->toBeApproximately($expectedCost, 0.01);
});

it('calculates bandwidth cost for backend application scenario', function () {
    // Example: 10M requests
    // Compute In: 1KB * 10M = 10GB
    // Compute Out: 10KB * 10M = 100GB
    // Compute External DB: 5KB * 10M = 50GB
    // Total: 10GB + 100GB + 50GB = 160GB
    // Plan Allowance (Production): 100GB
    // Chargeable: 160GB - 100GB = 60GB
    // Cost: 60GB * $0.10/GB = $6

    $totalDataTransferredGB = 160;
    $expectedCost = 6.00;

    $actualCost = $this->pricingService->calculateDataTransferCost($this->plan, $totalDataTransferredGB);

    expect($actualCost)->toBeApproximately($expectedCost, 0.01);
});

it('calculates requests cost for backend application scenario', function() {
    // Example: 10M requests
    // Plan Allowance (Production): 10M
    // Chargeable: 10M - 10M = 0
    // Cost: $0

    $totalRequestsMillions = 10;
    $expectedCost = 0.00;

    $actualCost = $this->pricingService->calculateRequestsCost($this->plan, $totalRequestsMillions);

    expect($actualCost)->toBeApproximately($expectedCost, 0.01);
});

// Add tests for other plans (sandbox, business) and edge cases 