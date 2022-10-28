<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminResource;
use App\Http\Resources\UserResource;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {

//        return $request;
//        $http = new \GuzzleHttp\user;
//
//        try {
//            $response = $http->post;('http://127.0.0.1:8000/oauth/token', [
//                'form_params' => [
//                    'grant_type' => 'password',
//                    'client_id' => 2,
//                    'client_secret' => '8bEdKUmK73egEBlPZgKxTf3zYduzpwn24m71Y5X6',
//                    'username' => $request['username'],
//                    'password' => $request['password'],
//                    'scope' => null
//
//                ]
//            ]);
//            return $response->getBody();
//
//        } catch (BadResponseException $e) {
//
//            return $e->getMessage();
////            if ($e->getCode() === 400) {
////                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
////            } else if ($e->getCode() === 401) {
////                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
////
////            }
////            return response()->json('Something wnt wrong on the server', $e->getCode());

//        }
//        $validator = Validator::make($request->all(), [
//            'email' => 'required|string|email|max:255',
//            'password' => 'required|string|min:6|confirmed',
//        ]);
//        if ($validator->fails())
//        {
//            return response(['errors'=>$validator->errors()->all()], 422);
//        }
//        $validator = Validator::make($request->all(), [
//            'email' => 'required|string|email|max:255',
//            'password' => 'required|string|min:3',
//        ]);
//        if ($validator->fails())
//        {
//            return response(['errors'=>$validator->errors()->all()], 422);
//        }
        try {
            $user = User::where('email', $request->username)->first();
            if ($user) {
                if (auth()->attempt(['email' => request('username'), 'password' => request('password')])) {
                    $token = $user->createToken('user')->accessToken;

                    $date = new \DateTime();
                    $date->add(new \DateInterval('PT2H'));

                    $user->update(['last_activity'=> $date->format('Y-m-d H:i:s')]);

                    return response(['user' => new UserResource($user), 'access_token' => $token, 'expire' => date_format($date, 'Y-m-d H:i:s')], 200);
                } else {
                    $response = ["password" => ["کلمه عبور اشتباه است"]];
                    return response($response, 422);
                }
            } else {
                $response = ["email" =>['کاربر وجود ندارد']];
                return response($response, 422);
            }
        } catch (\Exception $exception) {
            return response($exception);

        }

    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all('name', 'email', 'password'),
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:3',
//            'password' => 'required|string|min:3|confirmed',
            ],
            [
                'name.required' => 'لطفا نام را وارد کنید',
                'name.max' => 'نام بیش از حد طولانی است',
                'email.required' => 'لطفا ایمیل را وارد کنید',
                'email.unique' => 'این ایمیل قبلا ثبت شده',
                'password.required' => 'لطفا کلمه عبور را وارد کنید',
                'password.min' => 'لطفا حد اقل 3 کاراکتر وارد کنید',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        //event(new Registered($client));

        $accessToken = $user->createToken('authToken')->accessToken;
        return response(['user' => new UserResource($user), 'access_token' => $accessToken], 201);

//        $request['password']=Hash::make($request['password']);
//        $request['remember_token'] = Str::random(10);
//        $client = User::create($request->toArray());
//        $token = $client->createToken('Laravel Password Grant user')->accessToken;
//        $response = ['access_token' => $token];
//        return response($response, 200);
    }

    public function logout(User $user)
    {
        try {
//            return $user->tokens;
            $user->tokens->each->delete();
            foreach ($user->tokens as $token){
              return  $token->delete();
            }
            return response('successful logout', 200);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), $exception->getCode());

        }

    }

    public function updateLastActivity(Request $request)
    {
//        $id = 1;
        // $client = auth()->user();
        $user = User::find($request['id']);
        if (!$user) {
            return response(['message' => 'user does not exist'], 401);
        }
        $date = date('Y-m-d H:i:s');
        if ($user['last_activity'] === null) {
            $latest = $date;
        } else {
            $latest = $user['last_activity'];
        }
//        $userExpire = date('Y-m-d H:i:s',strtotime('+1 minutes',strtotime($latest)));

        $userExpire = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($latest)));
        if ($date > $userExpire) {
            return response(['message' => 'token expired'], 401);
        } else {
            $expDate = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($date)));
            $user->update(['last_activity' => $date]);
            return response(['message' => 'token updated', 'user' => new UserResource($user), 'expire' => $expDate], 200);
        }

    }

    public function currentUser()
    {
        try {
            return response(Auth()->user(), 200);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), $exception->getCode());

        }

    }

//    public function adminLogin(Request $request)
//    {
////       return auth()->guard('admin')->user();
//        $user = Admin::where('email', $request->email)->first();
//        if ($user) {
//            if (auth()->guard('admin')->attempt(['email' => request('email'), 'password' => request('password')])) {
//                $token = $user->createToken('admin')->accessToken;
//
//                $date = new \DateTime();
//                $date->add(new \DateInterval('PT2H'));
//
////                $user->update(['last_activity' => $date->format('Y-m-d H:i:s')]);
//
//                return response()->json(['admin' => new UserResource($user), 'access_token' => $token, 'expire' => date_format($date, 'Y-m-d H:i:s')], 200);
//            } else {
//                $response = ["password" => ["کلمه عبور اشتباه است"]];
//                return response($response, 422);
//            }
//        } else {
//            $response = ["email" => ['کاربر وجود ندارد']];
//            return response($response, 422);
//        }
//    }
//
//    public function currentAdmin()
//    {
//
////        config(['auth.guards.api.provider' => 'admin']);
////        $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
////        return  $admin;
//        try {
////            config(['auth.guards.api.provider' => 'admin']);
//            $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
//
//            return response($admin, 200);
//        } catch (\Exception $exception) {
//            return response($exception->getMessage(), $exception->getCode());
//
//        }
//
//    }


}
