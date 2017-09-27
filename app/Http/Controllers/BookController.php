<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\StoreBook;
use Illuminate\Http\Response;

class BookController extends Controller
{
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
