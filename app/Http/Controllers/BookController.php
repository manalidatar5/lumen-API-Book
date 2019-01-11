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

    }

    public function showAllBooks()
    {
        try {

            return response()->json(Book::all());
        }
        catch (\Exception $e)
        {
            return array('success' => false, 'message' => "Records not found");
        }
    }

    public function showOnebook($id)
    {
        try {

            return response()->json(Book::findOrFail($id));

        } catch (\Exception $ex)
        {
            return array('success' => false, 'message' => "Book not found");
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

            return array('success' => true, 'message' => "saved", 'data' => $book);

        } catch (\Exception $ex) {
            return array('success' => false, 'message' => "Not saved");
        }
    }

    public function update($id, Request $request)
    {
        try {
            $book = Book::find($id);
            $book->update($request->all());

            return array('success' => true, 'message' => "Updated successfully", 'data' => $book);
        } catch (\Exception $e) {
            return array('success' => false, 'message' => "not Updated");
        }
    }

    public function delete($id)
    {
        try {
            Book::findOrFail($id)->delete();
            return response('Deleted Successfully', 200);

        } catch (\Exception $ex)
        {
            return array('success' => false, 'message' => "Error");
        }
    }
}
