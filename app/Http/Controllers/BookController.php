<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class BookController extends Controller
{


    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function showAllBooks()
    {

        return response()->json(Book::all());

    }

    public function showOnebook($id)
    {
        try{

            return response()->json(Book::findOrFail($id));
        }
        catch (\Exception $ex)
        {
            $ex.abort(404);


        }

    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'bookname' => 'required',
            'user_id' => 'required'
        ]);
        try {
            $book = Book::create($request->all());

            return response()->json($book);
        }catch (\Exception $ex)
        {
            $ex.abort(404);
        }

    }

    public function update($id, Request $request)
    {
        try {
            $book = Book::find($id);
            $book->update($request->all());

            return response()->json($book, 200);
        }
        catch (\Exception $e)
        {
            $e.abort(404);
        }
    }

    public function delete($id)
    {
        try {


            Book::findOrFail($id)->delete();
            return response('Deleted Successfully', 200);
        }
        catch (\Exception $ex){
            $ex.abort(404);
        }
    }



}
