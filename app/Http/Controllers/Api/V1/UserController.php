<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function get_users()
    {
        $users = User::with('roles')->get();
        return $users;
    }
    public function get_roles()
    {
        $roles = Role::all();
        return $roles;
    }
    public function register(Request $request)
    {

        $fields = $request->validate([
            'name'  => 'required|string',
            'phone_number'  => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'role_id' => 'required|exists:roles,id',
            'password_confirmation' => 'required|same:password'
        ]);

        $user = new User();
        $user->name = $fields['name'];
        $user->email = $fields['email'];
        $user->phone_number = $fields['phone_number'];
        $user->role_id = $fields['role_id'];
        $user->password = bcrypt($fields['password']);
        $user->state=1;
        // if ($request->image) {
        //     $filename = $request->image->getClientOriginalName();
        //     $destinationPath = public_path('user_profile');
        //     $request->image->move($destinationPath, $filename);
        //     $user->image = 'user_profile/'.$filename;
        // }
        $user->save();

        $token = $user->createToken('Token of ' .$user->name)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return $response;
    }
    public function add_tutor(Request $request)
    {
        $fields = $request->validate([
            'name'  => 'required|string',
            'surname'  => 'required|string',
            'adresse'  => 'required|string',
            'phone_number'  => 'required|string',
            'cv'  => 'required|string',
            'email' => 'unique:users,email',
        ]);

        $user = new User();
        $user->name = $fields['name'];
        $user->email = $fields['email'];
        $user->adresse = $fields['adresse'];
        $user->phone_number = $fields['phone_number'];
        $user->role_id = 4;
        $user->state = true;
        $user->save();

        $response = [
            'user' => $user,
        ];
        return $response;

    }
    public function show(Request $request,$id)
    {
        return User::where('id',$id)->get();
    }
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        // check email if exist in database

        // $champs = 'email';
        // if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
        //     $champs = 'username';
        // }

        $user = User::where($fields['email'])->first();

        // check password
        if(!$user){
            return response([
                'message' => "User doesn't exist"
            ], 401);
        }
        if ( !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Wrong password'
            ], 401);
        }

        $token = $user->createToken('Token of ' .$user->name)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            // 'roles' => $user->roles,
        ];
        return response($response, 201);
    }
    public function logout(User $user)
    {
        Auth::user()->tokens()->delete();

        return [
            'message' => 'Logged Out'
        ];
    }

    public function changeState(User $user,$id)
    {
        $user= User::where('id',$id)->get('state');
        $users=json_decode($user);
        if($users[0]->state==true){
            return User::where('id',$id)->update(['state'=>0]);
        }else{
            return User::where('id',$id)->update(['state'=>1]);
        }

        // return $menus[0]->state;
    }


    public function changePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ], [
            'old_password.required' => 'Enter the old password',
            'new_password.required' => 'Entrer un nouveau mot de passe',
            'new_password.min' => 'Entrer minimum 5 characters',
            'new_password.max' => 'Entrer maximum 25 characters',
            'new_password_confirmation.same' => 'Must be the same with the new password',
        ]);


        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return response()->json(
                [
                    'success' => false,
                    'msg' => 'Ancien mot de passe incorrect'
                ],
                200
            );
        }
        #Update the new Password
        $user = User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        return $user;
    }

    public function updateUser(Request $request,$id)
    {
        $fields = $request->validate([
            'name'  => 'required|string',
            'phone_number'  => 'required|string',
            'email' => 'required',
            'password' => 'required|confirmed',
            'role_id' => 'required|exists:roles,id',
            'password_confirmation' => 'required|same:password'
        ]);

        $users=user::where('id',$id)->update([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone_number' => $fields['phone_number'],
            'role_id' => $fields['role_id'],
            'password' => bcrypt($fields['password']),
            ]);
        // $token = $user->createToken('Token of ' .$user->name)->plainTextToken;

         $response=[
            'user'=>$users,
            // 'token'=>$token
        ];
        return response($response,201);
    }

    public function updateTutor(Request $request,$id)
    {
        $fields = $request->validate([
            'name'  => 'required|string',
            'adresse'  => 'required|string',
            'phone_number'  => 'required|string',
        ]);

        $users=user::where('id',$id)->update([
            'name' => $fields['name'],
            'email' => $request['email'],
            'phone_number' => $fields['phone_number'],
            'adresse' => $request['adresse'],
            ]);

         $response=[
            'user'=>$users,
            // 'token'=>$token
        ];
        return response($response,201);
    }

    public function updateConnectedUserProfile(Request $request,$id)
    {
        $fields = $request->validate([
            'name'  => 'required|string',
            'username'  => 'required|string',
            'adresse'  => 'required|string',
            'phone_number'  => 'required|string',
            'email' => 'required',
        ]);

        $users=user::where('id',$id)->update([
            'name' => $fields['name'],
            'username' => $fields['username'],
            'email' => $fields['email'],
            'phone_number' => $fields['phone_number'],
            'adresse' => $fields['adresse'],
            // 'birthday' => $fields['birthday'],
            // 'cni' => $fields['cni'],
            // 'passportId' => $request->passportId,
            // 'nationality' => $fields['nationality'],
            // 'gender' => $fields['gender']
            ]);
        // $token = $user->createToken('Token of ' .$user->name)->plainTextToken;

         $response=[
            'user'=>$users,
            // 'token'=>$token
        ];
        return response($response,201);
    }
}
