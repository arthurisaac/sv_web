<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index() {
        $sliders = Slider::query()->get();
        return response()->json(["data" => $sliders]);
    }
}
