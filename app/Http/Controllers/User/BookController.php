<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Book;
use App\Review;
use App\Lease;
use App\Category;
use DB;
use Illuminate\Http\Request;
use Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allBooks = Book::paginate(15);
        $favourites = Auth::user()->favourites->pluck("book_id")->toArray();
        $leases = Auth::user()->leases->pluck("book_id")->toArray();
        return view('user.books.index',compact('allBooks', 'favourites', 'leases'));       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $reviews = Review::leftJoin('users', 'reviews.user_id', '=', 'users.id')
            ->select('reviews.*', 'users.name', 'users.avatar')
            ->where('book_id', $book->id)->orderBy('reviews.rate', 'desc')->get();

        $userReview = Review::leftJoin('users', 'reviews.user_id', '=', 'users.id')
            ->select('reviews.*', 'users.name', 'users.avatar')
            ->where([['book_id', $book->id], ['user_id', Auth::id()]])->first();
        $relatedBooks = Book::where([['category_id', $book->category_id], ['id', '!=', $book->id]])->get();
        if(count($relatedBooks)>10){
            $relatedBooks = $relatedBooks->random(10);
        }
        $userLease = Lease::where([['book_id', $book->id], ['user_id', Auth::id()], ['deleted_at', null]])->select('leases.*', DB::raw('DATEDIFF(end_date, created_at) as remaining'))->first();
        $book = Book::find($book->id);
        $category=Category::find($book->category_id);
        $favourites = Auth::user()->favourites->pluck("book_id")->toArray();
        return view('user.books.show', compact('book', 'favourites', 'category', 'reviews', 'userReview', 'userLease', 'relatedBooks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
