<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\StoreBook;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBook $request
     * @return array|Book
     */
    public function store(StoreBook $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  Book $book
     * @return Book
     */
    public function show(Book $book)
    {
        return $book;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreBook $request
     * @param  Book      $book
     * @return Book
     */
    public function update(StoreBook $request, Book $book)
    {
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Book $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book::destroy($book->id);

        return response()->json([], Response::HTTP_ACCEPTED);
    }
}
