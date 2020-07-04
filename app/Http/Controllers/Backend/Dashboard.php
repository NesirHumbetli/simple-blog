<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;

class Dashboard extends Controller
{
    public function index()
    {
        $hit = Article::sum('hit');
        $article = Article::all()->count();
        $category = Category::all()->count();
        $page = Page::all()->count();
        return view('backend.dashboard',compact(['article','hit','category','page']));
    }
}
