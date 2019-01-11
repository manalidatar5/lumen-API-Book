<?php

namespace App\Http\Controllers;

use App\Book;

use http\Env\Response;
use http\Message;
use Illuminate\Http\Request;

use App\User;


class UserController extends Controller
{

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'

        ]);

        $hasher = app()->make('hash');
        $email = $request->input('email');
        $name = $request->input('name');
        $password = $hasher->make($request->input('password'));
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $res['success'] = true;
        $res['message'] = 'Success register!';
        $res['data'] = $user;
        return response($res);
    }

    public function getbooks($id)
    {
        try {
            return response()->json($books = User::findOrFail($id)->books);
        } catch (\Exception $ex) {

            return array('success' => false, 'message' => "Book not found");

        }

    }

}
