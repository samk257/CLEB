<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'avatar' => 'required',
            'name' => 'required',
            'type' => 'required',
            'open_id' => 'required',
            'email' => 'max:50',
            'telephone' => 'max:30',
            // 'password' => 'min:6',
            ]);
        if ($validator->fails()) {
        return ["code" => -1, "data" => "no valid data", "msg" => $validator->errors()->first()];
        }
        try {
        //1:email，2:google,  3:facebook,4 apple,5 phone
        $validated = $validator->validated();

        $map=[];
        $map["type"] = $validated["type"];
        $map["open_id"] = $validated["open_id"];

        $res = DB::table("users")->select("avatar","name","description","type","token","access_token","online")->where($map)->first();
        if(empty($res)){
            $validated["token"] = md5(uniqid().rand(10000,99999));
            $validated["created_at"] = Carbon::now();
            //$validated["password"] = Hash::make($validated['password']);
            $validated["access_token"] = md5(uniqid().rand(1000000,9999999));
            $validated["expire_date"] = Carbon::now()->addDays(30);
            $user_id = DB::table("users")->insertGetId($validated);
            $user_res = DB::table("users")->select("avatar","name","description","type","access_token","token","online")->where("id","=",$user_id)->first();
            return ["code" => 0, "data" => $user_res, "msg" => "success"];
        }

        $access_token = md5(uniqid().rand(1000000,9999999));
        $expire_date = Carbon::now()->addDays(30);
        DB::table("users")->where($map)->update(["access_token"=>$access_token,"expire_date"=>$expire_date]);
        $res->access_token = $access_token;

        return ["code" => 0, "data" => $res, "msg" => "success update"];

        } catch (Exception $e) {
        return ["code" => -1, "data" => "", "msg" => $e];
        }
    }
    public function createUser(Request $request)
    {
        try{
            //validated
            $validateUser = Validator::make($request->all(), [
                'avatar' => 'required',
                'name' => 'required',
                'type' => 'required',
                'open_id' => 'required',
                'email' => 'max:50',
                'telephone' => 'max:30',

            ]);
            if ($validateUser->fails()) {
                return response()->json([
                    'code' => 401,
                    'msg' => $validateUser->errors(),
                    'data' => "Donnees invalides"
                ],401);

            }
            $validated = $validateUser->validated();

            $map=[];
            $map["type"] = $validated["type"];
            $map["open_id"] = $validated["open_id"];

            $user = User::where($map)->first();
            if(empty($user->id)){
                $validated["token"] = md5(uniqid().rand(10000,99999));
                $validated["created_at"] = Carbon::now();
                $validated["expire_date"] = Carbon::now()->addDays(30);
                $userID = User::insertGetId($validated);
                $userInfo = User::where('id', "=", $userID)->first();

                $accessToken = $userInfo->createToken(uniqid())->plainTextToken;

                $userInfo->access_token = $accessToken;
                User::where('id','=', $userID)->update(['access_token'=>$accessToken]);
                return response()->json([
                    'code' => 200,
                    'msg' => "User Created Successfully",
                    'data' => $userInfo
                ],200);

            }

            //user previously has logged in
            $accessToken = $user->createToken(uniqid())->plainTextToken;
            $user->access_token = $accessToken;
            $expire_date = Carbon::now()->addDays(30);
            User::where($map)->update(['access_token'=>$accessToken,"expire_date"=>$expire_date]);
            //'open_id', '=', $validated['open_id']
            return response()->json([
                'code' => 200,
                'msg' => "User updated Successfully",
                'data' => $user
            ],200);

    }catch(\Throwable $th){
        return response()->json([
            'code' => 500,
            'msg'  => $th->getMessage(),
            'data' => ""
        ],500);


        }
    }
}
