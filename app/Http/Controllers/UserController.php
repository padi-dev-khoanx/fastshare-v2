<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        @session_start();
    }

    /**
     * @return View
     */
    public function login()
    {
        return view('user/login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'failed',
                    'msg'=> $validator->errors()
                ]
            );
        }

        $email = $request->get('email');
        $password = $request->get('password');
        if ($email == 'admin' && $password == 'admin') {
            $_SESSION['user'] = 'admin';
            return response()->json(
                [
                    'status' => 'success'
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 'failed',
                    'msg' => 'Tài khoản hoặc mật khẩu ko chính xác'
                ]
            );
        }
    }

    /**
     * @return View
     */
    public function register()
    {
        return view('user/register');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique',
            'password' => 'required',
            'repassword' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'failed',
                    'msg'=> $validator->errors()
                ]
            );
        }

        if ($request->get('password') !== $request->get('repassword')) {
            return response()->json(
                [
                    'status' => 'failed',
                    'msg'=> "Nhập lại mật khẩu chưa đúng."
                ]
            );
        }

        $data = [];
        $data['name'] = $request->get('name');
        $data['email'] = $request->get('email');
        $data['password'] = Hash::make($request->get('password'));

        User::create($data);

        return response()->json(
            [
                'status' => 'success'
            ]
        );
    }

    /**
     * @return View
     */
    public function account()
    {
        return view('user/account');
    }

    public function logout(){
        $_SESSION['user'] = '';
        return view('index');
    }
}