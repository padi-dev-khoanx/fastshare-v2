<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\Orders;
use App\Models\Text;
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
        $validatorArray = [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'repassword' => 'required',
        ];
        $messageerror = [
            'name.required' => 'Thiếu họ tên',
            'email.required' => 'Thiếu email',
            'email.unique' => 'Email đã tồn tại',
            'password.min' => 'Mật khẩu ít nhất 6 ký tự',
            'password.required' => 'Thiếu password',
            'repassword.required' => 'Thiếu nhập lại password',
        ];
        $validator = Validator::make($request->all(), $validatorArray, $messageerror);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        if ($request->get('password') !== $request->get('repassword')) {
            return redirect()->back()->withErrors(['Mật khẩu nhập lại không khớp']);
        }

        $data = [];
        $data['name'] = $request->get('name');
        $data['email'] = $request->get('email');
        $data['type_user'] = 0;
        $data['password'] = Hash::make($request->get('password'));

        User::create($data);

        return redirect()->route('home.index');
    }

    /**
     * @return View
     */
    public function account()
    {
        if (Auth::user()) {
            $userFile = FileUpload::where('user_id', Auth::user()->id)->get();
            $userText = Text::where('user_id', Auth::user()->id)->get();
            if(Auth::user()->type_user == User::TYPE_ADMIN_USER) {
                $listUser = User::whereIn('type_user', [User::TYPE_NORMAL_USER, User::TYPE_VIP_USER])->with('order')->get();
                return view('statistical', compact('listUser'));
            } else {
                return view('user/account', compact('userFile', 'userText'));
            }
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
                $user->vip_end_date = date('Y-m-d', strtotime('+1 months'));
                $user->save();
                $order['user_id'] = Auth::user()->id;
                $order['price'] = 5;
                $order['create_date'] = now();
                $order['end_date'] = date('Y-m-d', strtotime('+1 months'));
                Orders::create($order);
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

    public function edit()
    {
        return view('user.edit');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.Auth::user()->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['Thông tin nhập vào không hợp lệ']);
        }

        $data = User::find(Auth::user()->id);
        $data['name'] = $request->get('name');
        $data['email'] = $request->get('email');
        $data->save();

        return redirect(route('user.account'))->with('success', 'Cập nhật người dùng thành công');

    }

    public function delete($id)
    {
        $user = User::find($id);
        if (Auth::user()->type_user = User::TYPE_ADMIN_USER) {
            $user->delete();
            return redirect()->back()->with('success', 'Xóa người dùng thành công');
        } else {
            return redirect()->back()->withErrors(['Bạn không có quyền xóa người dùng']);
        }
    }
}
