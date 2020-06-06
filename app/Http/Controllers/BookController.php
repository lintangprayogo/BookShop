<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->status;
        $keyword = $request->keyword ? $request->keyword : '';
        if ($status) {
            $books = Book::with('categories')->where('status', strtoupper($status))->where('title', 'LIKE', "%$keyword%")->paginate(10);
        } else {
            $books = Book::with('categories')->where('title', 'LIKE', "%$keyword%")->paginate(10);
        }

        return view("books.index", ["books" => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("books.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_book = new Book;
        $new_book->title = $request->title;
        $new_book->description = $request->description;
        $new_book->author = $request->author;
        $new_book->publisher = $request->publisher;
        $new_book->price = $request->price;
        $new_book->stock = $request->stock;

        $new_book->status = $request->save_action;

        if ($request->cover) {
            $cover_path = $request->cover->store('book-covers', 'public');
            $new_book->cover = $cover_path;
        }
        $new_book->slug = Str::slug($request->title);
        $new_book->created_by = Auth::id();
        $new_book->save();
        $new_book->categories()->attach($request->categories);


        if ($request->save_action == 'PUBLISH') {
            return redirect()->route("books.create")->with('status', "Book successfully saved and published");
        } else {
            return redirect()->route("books.create")->with('status', "Book saved as draft");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $book = Book::findOrFail($id);
        return view("books.edit", ["book" => $book]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $book = Book::findOrFail($id);
        $book->title = $request->title;
        $book->description = $request->description;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->price = $request->price;
        $book->stock = $request->stock;

        $book->status = $request->status;

        if ($request->cover) {
            $cover_path = $request->cover->store('book-covers', 'public');
            $book->cover = $cover_path;
        }
        $book->slug = Str::slug($request->title);
        $book->created_by = Auth::id();
        $book->save();
        $book->categories()->sync($request->categories);

        return redirect()->route('books.edit', [$book->id])->with('status', 'Book successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route("books.index")->with("status", "Book has been moved to trash");
    }


    public function ajaxSearch(Request $request)
    {
        $keyword = $request->q;
        $categories = Category::where("name", "LIKE", "%$keyword%")->get();

        return $categories;
    }




    public function trash()
    {
        $books = Book::onlyTrashed()->paginate(10);
        return view("books.trash", ["books" => $books]);
    }

    public function permanentDelete($id)
    {
        $book = Book::withTrashed()->findOrFail($id);
        if (!$book->trashed()) {
            return redirect()->route('books.index')
                ->with('status', 'Can not delete permanent active book');
        } else {
            $book->forceDelete();
            return redirect()->route('books.index')
                ->with('status', 'Book permanently deleted');
        }
    }

    public function restore($id){
        $book = Book::withTrashed()->findOrFail($id);
        if ($book->trashed()) {
            $book->restore();
        } else {
            return redirect()->route('books.index')->with('status', 'Book is not in trash');
        }
        return redirect()->route('books.index')->with('status', 'Book has been restored');
    }
}
