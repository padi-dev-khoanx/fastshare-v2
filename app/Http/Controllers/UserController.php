<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Stripe\Charge;
use Stripe\Stripe;

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
        if ( Auth::attempt(['email' => $email, 'password' =>$password])) {
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
            'email' => 'required|unique:users',
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
        $data['type_user'] = 0;
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
        if (Auth::user()) {
            return view('user/account');
        } else {
            return redirect(route('user.login'));
        }

    }

    public function logout(){
        Auth::logout();
        return redirect(route('user.login'));
    }

    public function buyVIP() {
        if (auth()->user()->type_user == User::TYPE_NORMAL_USER) {
            return view('user.buyVIP');
        } else {
            return redirect(route('user.account'));
        }
    }

    public function getVIP(Request $request) {
        $data = $request->all();
        Stripe::setApiKey('sk_test_51J2oK7IGpnh72CVoHGplP3oYITO483rOliW4PwYVj5TBLHDUXZpUd6d5npcMgzS632UVLM5DZAbdf9nvJGTSuebn00hsJmMiyI');
        $myCard = array('number' => $data['card_number'], 'exp_month' => $data['month_exp'], 'exp_year' => $data['year_exp']);
        try {
            $charge = Charge::create(array('card' => $myCard, 'amount' => 500, 'currency' => 'usd'));
            if($charge->paid) {
                $user = User::find(Auth::user()->id);
                $user->type_user = User::TYPE_VIP_USER;
                $user->save();
                $order['user_id'] = Auth::user()->id;
                $order['price'] = 5;
                Order::create($data);
                return redirect(route('user.account'))->with('success', 'Mua gói VIP thành công');
            } else {
                return redirect()->back()->withErrors(['Lỗi hệ thống']);
            }
        } catch(\Stripe\Error\Card $e) {
            return redirect()->back()->withErrors(['Hãy kiểm tra lại thẻ của bạn']);
        } catch (\Stripe\Error\RateLimit $e) {
            return redirect()->back()->withErrors(['Lỗi hệ thống']);
        } catch (\Stripe\Error\InvalidRequest $e) {
            return redirect()->back()->withErrors(['Lỗi hệ thống']);
        } catch (\Stripe\Error\Authentication $e) {
            return redirect()->back()->withErrors(['Lỗi bảo mật hệ thống']);
        } catch (\Stripe\Error\ApiConnection $e) {
            return redirect()->back()->withErrors(['Lỗi mạng']);
        } catch (\Stripe\Error\Base $e) {
            return redirect()->back()->withErrors(['Lỗi hệ thống']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Lỗi hệ thống']);
        }
    }
}
