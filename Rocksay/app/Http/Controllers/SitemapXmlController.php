<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Products;
use Illuminate\Http\Request;

class SitemapXmlController extends Controller
{
    public function index() {
        $posts = Blogs::orderBy('start_post', 'asc')->limit(10)->where('status', 1)->get();
        $products = Products::orderBy('created_at', 'desc')->where('status', 1)->get();
        return response()->view('sitemap', [
            'posts' => $posts,
            'products' => $products
        ])->header('Content-Type', 'text/xml');
      }
}
