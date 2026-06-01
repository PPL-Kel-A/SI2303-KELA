<?php

namespace App\Http\Controllers;

use App\Models\Reward;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::where('user_id', auth()->id())
            ->latest()
            ->get();

        $totalPoints = auth()->user()->points;

        return view('reward.index', compact('rewards', 'totalPoints'));
    }
}