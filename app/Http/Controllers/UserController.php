<?php

namespace App\Http\Controllers;

use App\Book;

use http\Env\Response;
use Illuminate\Http\Request;

use App\User;


class UserController extends Controller
{

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' =>'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'

        ]);

        $hasher = app()->make('hash');
        $email = $request->input('email');
        $name=$request->input('name');
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
            ($books = User::find($id)->books);

            return array('success' => true, 'Books' => $books);
        }
        catch (\Exception $ex)
        {
            $ex.abort(404);

        }

       // return array('success' => false);
    }



    public function login(Request $request)
    {
//        $validator = validate::make($request->all(), [
//            'email' => 'required',
//            'password' => 'required'
//        ]);
//
//        if ($validator->fails()) {
//            return array(
//                'error' => true,
//                'message' => $validator->errors()->all()
//            );
//        }

        $user = User::where('email', $request->input('email'))->first();

        if ((count($user))) {
            if (password_verify($request->input('password'), $user->password)) {
                unset($user->password);
                return array('error' => false, 'user' => $user);
            } else {
                return array('error' => true, 'message' => 'Invalid password');
            }
        } else {
            return array('error' => true, 'message' => 'User not exist');
        }
    }
}
