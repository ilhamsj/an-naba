<?php

namespace App\Http\Controllers;

use App\Review;
use App\ArticleComment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function index()
    {
        $items = Review::where('category', 'Review')->get();
        return datatables($items)
            ->addColumn('name', function ($items) {
                return $items->user->name;
            })
            ->addColumn('email', function ($items) {
                return $items->user->email;
            })
            ->addColumn('action', function ($items) {
                return
                    '
                    <a href="" class="btnDelete btn btn-primary btn-icon-split btn-sm" data-url="' . route('reviews.destroy', $items->id) . '"><span class="icon text-white-50"> <i class="fa fa-check"></i> </span></a>
                ';
            })
            ->rawColumns(['user_id', 'name', 'email', 'action'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required',
            'content'       => 'required',
            'category'      => 'required',
            'article_id'    => Rule::requiredIf($request->category == 'Komentar'),
        ]);

        $item = Review::create($request->all());

        if ($request->category == 'Komentar') :
            $comment = ArticleComment::create([
                'article_id'    => $request->article_id,
                'review_id'     => $item->id,
            ]);
        endif;

        return response()->json([
            'status' => $request->category . ' Success'
        ]);
    }

    public function destroy($id)
    {
        $item = ArticleComment::find($id);

        return response()->json([
            'item'      => $item,
            'status'    => 'Delete Success'
        ]);
    }
}
