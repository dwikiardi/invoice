<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('users.list');
    }

    public function list(){
        try{
            $user = json_decode(User::get(), true);

            foreach($user as $key => $value) {
                $data[] = [
                    "id" => $value['id'],
                    "nama" => $value['name'],
                    "email" => $value['email'],
                    'jabatan' => $value['jabatan'],
                ];
            }
            return response()->json($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        try {
            User::create([
                'name' => $request['nama'],
                'email' => $request['email'],
                'jabatan' => $request['jabatan'],
                'password' => Hash::make($request['password']),
            ]);
            return response()->json('success');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete(Request $request)
    {
        try {
            User::find($request->id)->delete();
            return response()->json('success');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
