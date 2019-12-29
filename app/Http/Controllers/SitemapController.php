<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        return response()->view('sitemap.index', [
            'post' => Article::orderBy('updated_at', 'desc')->first()
        ], 200)->header('Content-Type', 'text/xml');
    }

    public function articles()
    {
        return response()->view('sitemap.articles', [
            'articles' => Article::orderBy('updated_at', 'desc')->get()
        ], 200)->header('Content-Type', 'text/xml');
    }
}
