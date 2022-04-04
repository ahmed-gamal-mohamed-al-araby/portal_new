<?php

namespace App\Http\Controllers\UserRole;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-roles-page');
    }
    public function index()
    {
        $data = [];
        $users_role = DB::table('model_has_roles')->get();
        foreach ($users_role as $key => $user_role) {
            $user = User::where("id", $user_role->model_id)->first();
            $role = DB::table('roles')->where("id", $user_role->role_id)->first();
            $data[$key] = ["username" => $user->username, "rolename" => $role->name, "username_id" => $user_role->model_id, "rolename_id" => $user_role->role_id];
        }

        //    dd($data) ;
        return view("dashboard-views.user_role.index", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users =  User::all();
        $roles = Role::all();
        return view("dashboard-views.user_role.create", compact("users", "roles"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find($request->user_id);
        foreach ($request->role_id as $role) {
            $user->assignRole($role);
        }
        return redirect()->route('user-roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $users =  User::all();
        $username_id = $id;
        $roles = [];
        $role_all = DB::table('model_has_roles')->where("model_id", $id)->get();
        foreach ($role_all as $key => $value) {

           $roles_select[$key]= $value->role_id;
        }
        $roles = Role::all();
        return view("dashboard-views.user_role.edit", compact("users", "roles", "username_id", "roles_select"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($request->user_id);
        $role_all = DB::table('model_has_roles')->where("model_id", $request->user_id)->delete();

        foreach ($request->role_id as $role) {
            $user->assignRole($role);
        }
        return redirect()->route('user-roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        // return $request;

        $users_role = DB::table('model_has_roles')->where("model_id", $request->username_id)->where("role_id", $request->rolename_id)->delete();
        return redirect()->back();
    }
}
