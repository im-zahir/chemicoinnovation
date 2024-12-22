<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\AboutSetting;
use App\Models\Team;

class AboutController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $team = Team::where('is_active', true)
            ->orderBy('order')
            ->get();

        $aboutSettings = AboutSetting::first();

        return view('about.index', compact('testimonials', 'team', 'aboutSettings'));
    }
}
