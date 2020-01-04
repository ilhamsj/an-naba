<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Document;
use App\Review;

class SitemapController extends Controller
{
    public function index()
    {
        return response()->view('sitemap.index', [
            'articles' => Article::orderBy('updated_at', 'desc')->first(),
            'documents' => Article::orderBy('updated_at', 'desc')->first(),
            'categories' => Article::orderBy('updated_at', 'desc')->first(),
            'reviews' => Article::orderBy('updated_at', 'desc')->first(),
        ], 200)->header('Content-Type', 'text/xml');
    }

    public function articles()
    {
        return response()->view('sitemap.articles', [
            'items' => Article::orderBy('updated_at', 'desc')->get()
        ], 200)->header('Content-Type', 'text/xml');
    }

    public function documents()
    {
        return response()->view('sitemap.documents', [
            'items' => Document::orderBy('updated_at', 'desc')->get()
        ], 200)->header('Content-Type', 'text/xml');
    }

    public function categories()
    {
        return response()->view('sitemap.categories', [
            'items' => Category::orderBy('updated_at', 'desc')->get()
        ], 200)->header('Content-Type', 'text/xml');
    }

    public function reviews()
    {
        return response()->view('sitemap.reviews', [
            'items' => Review::orderBy('updated_at', 'desc')->get()
        ], 200)->header('Content-Type', 'text/xml');
    }
}
