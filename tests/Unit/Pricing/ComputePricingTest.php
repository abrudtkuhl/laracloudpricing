<?php

use App\Services\PricingService;

// Use beforeEach to instantiate the service for each test
beforeEach(function () {
    $this->pricingService = new PricingService();
});

it('calculates compute cost for hibernation scenario', function () {
    $instanceSizeKey = 'flex-1c-256m'; // Key from config
    $hoursPerDay = 8;
    $daysPerWeek = 5;
    $weeks = 4;
    $totalActiveHours = $hoursPerDay * $daysPerWeek * $weeks; // 160 hours

    $expectedCost = 1.07; // 160 * $0.0067

    $actualCost = $this->pricingService->calculateHourlyComputeCost($instanceSizeKey, $totalActiveHours);

    // Use rounding assertion due to potential float inaccuracies
    expect($actualCost)->toBeApproximately($expectedCost, 0.01);
});

it('calculates compute cost for autoscaling scenario', function () {
    $instanceSizeKey = 'flex-1c-256m'; // Key from config
    $hourlyRate = 0.0067;

    $hoursAtScale = [
        1 => 360, // Using the example's calculation: 360*1
        2 => 200,
        3 => 100,
        4 => 100,
        5 => 20,
    ];

    $totalComputeHours = (360*1) + (200*2) + (100*3) + (100*4) + (20*5); // 1560 hours
    $expectedCost = 10.45; // 1560 * $0.0067

    $actualCost = $this->pricingService->calculateAutoscalingComputeCost($instanceSizeKey, $hoursAtScale);

    // Use rounding assertion
    expect($actualCost)->toBeApproximately($expectedCost, 0.01);

    // Optional: Verify total compute hours calculation if needed separately
    // $calculatedTotalHours = 0;
    // foreach ($hoursAtScale as $scale => $hours) {
    //     $calculatedTotalHours += $scale * $hours;
    // }
    // expect($calculatedTotalHours)->toBe($totalComputeHours);
});

// Add more unit tests for other PricingService methods as needed
// e.g., test calculateMonthlyComputeCost, calculateDatabaseCost etc.

it('calculates monthly compute cost correctly', function() {
    $sizeKey = 'flex-2c-2g'; // 20.29 monthly
    $instances = 3;
    $expectedCost = 20.29 * 3; // 60.87

    $actualCost = $this->pricingService->calculateMonthlyComputeCost($sizeKey, $instances);
    expect($actualCost)->toBeApproximately($expectedCost, 0.01);
}); 