<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\Notes;
use App\Models\Products;
use Illuminate\Http\Request;
use Mockery\Matcher\Not;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $blogs = Blogs::get()->count();
        $products = Products::get()->count();
        $products_sem_estoque = Products::where('units', '=', 0)->count();
        return view('admin.dashboard', compact('blogs', 'products', 'products_sem_estoque'));
    }
}
