<?php

namespace App\Http\Controllers;

use App\Services\PricingService;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    protected $pricingService;
    
    public function __construct(PricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }
    
    public function index()
    {
        $config = config('laracloud');
        return view('pricing', compact('config'));
    }
    
    public function generateConfiguration(Request $request)
    {
        $request->validate([
            'description' => 'required|string|min:5|max:500'
        ]);
        
        $userDescription = $request->input('description');
        $configuration = $this->pricingService->generatePricingConfiguration($userDescription);
        
        return response()->json($configuration);
    }
} 