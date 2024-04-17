<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'group' => 'required|string|max:255',
            'banner_type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'banner_text' => 'required|string'
        ]);
        $banner = new Banner($validated);
        $banner->save();

        return response()->json(['message' => 'Banner success save', 'data' => $banner]);
    }

    public function Groups($group): \Illuminate\Http\JsonResponse
    {
        $currentTime = date('Y-m-d');

        $banners = Banner::where('group', $group)
            ->where('end_date', '>=', $currentTime)
            ->get();

        $output = [];
        foreach ($banners as $banner) {
            $output[] = array(
                'type' => $banner->type,
                'title' => $banner->title,
                'banner_text' => $banner->banner_text
            );
        }
        return response()->json(json_encode($output));
    }

}

