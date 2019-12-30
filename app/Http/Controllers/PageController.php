<?php

namespace App\Http\Controllers;

use App\Article;
use App\Document;

class PageController extends Controller
{
    protected $articles;
    protected $news;
    protected $documents;


    public function welcome()
    {
        return view('welcome')->with([
            'articles'  => Article::all(),
            'slider'    => Document::where('category', 'slider')->get(),
            'news'      => Article::paginate(5),
        ]);
    }

    public function artikel_index()
    {
        return view('articles')->with([
            'articles'  => Article::all(),
            'news'      => Article::paginate(5),
        ]);
    }

    public function artikel_show($slug)
    {
        $item = Article::where('slug', $slug);

        if ($item->count() > 0) :
            return view('article')->with([
                'item'      => $item->first(),
                'news'      => Article::paginate(5),
            ]);
        else :
            return view('404');
        endif;
    }
}
