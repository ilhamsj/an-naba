<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        return view('admin.dashboard')->with([
            'data' => [
                'users'         => \App\User::all(),
                'categories'    => \App\Category::all(),
                'articles'      => \App\Article::all(),
                'documents'     => \App\Document::all(),
            ]
        ]);
    }

    public function articles()
    {
        return view('admin.articles');
    }

    public function files()
    {
        return view('admin.files');
    }

    public function documents()
    {
        return view('admin.documents');
    }

    public function galleries()
    {
        return view('admin.galleries');
    }

    public function reviews()
    {
        return view('admin.reviews');
    }

    public function users()
    {
        return view('admin.users');
    }
}
