<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CategoryController extends Controller
{
    public function index()
    {
        $items = Category::all();
        return datatables($items)
            ->addIndexColumn()
            ->addColumn('action', function ($items) {
                return
                    '
                    <a href="" class="btnEdit mx-0 btn btn-secondary btn-sm btn-icon-split" data-url="' . route('categories.destroy', $items->id) . '"> <span class="icon text-white-50"> <i class="fas fa-pencil-alt"></i> </span> </a>
                    <a href="" class="btnDelete btn btn-danger btn-icon-split btn-sm" data-url="' . route('categories.destroy', $items->id) . '"><span class="icon text-white-50"> <i class="fas fa-trash-alt"></i> </span></a>
                ';
            })
            ->addColumn('content', function ($items) {
                $data = count($items->Article);
                return $data;
            })
            ->toJson();
    }

    public function create()
    {
        return view('admin.article.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
        ]);

        $item = Category::create($request->all());

        return response()->json([
            'item'  => $request->all(),
            'status' => 'Store Success'
        ]);
    }

    public function show($id)
    {
        return response()->json(Category::find($id));
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        $item = Category::find($id);
        $item->update($request->all());

        return response()->json([
            'data'      => $request->all(),
            'status'    => 'Update Success',
        ]);
    }

    public function destroy($id)
    {
        $item = Category::find($id);
        $item->delete();

        return response()->json([
            'item'      => $item,
            'status'    => 'Delete Success'
        ]);
    }
}
