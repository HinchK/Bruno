<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ScorecardResource;
use App\Models\Category;
use App\Models\Scorecard;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    public function scorecards($id)
    {
        $scorecards = Scorecard::where('category_id', $id)->orderBy('id', 'desc')->paginate();
        return ScorecardResource::collection($scorecards);
    }
}
