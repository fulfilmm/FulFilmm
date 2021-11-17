<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('role.createAndEdit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        //
//        dd($req);
        Role::create(['name' => $req->name, 'guard_name' => 'employee']);
        return redirect('roles')->with('success', __('alert.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
        $permissions = Permission::all();
        $type = Permission::all()->pluck('type', 'id');
        $hasPermissions = $role->permissions->pluck('id');
//         dd($hasPermissions);
        return view('role.show', compact('role', 'permissions', 'hasPermissions','type'));
    }

    public function assignPermission($id, Request $req)
    {
//        dd($req);
        $role = Role::find($req->id);
        $role->givePermissionTo($req->permissions);

        return redirect('roles')->with('success', __('alert.create_success'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('role.createAndEdit', compact('role'));

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        $role->update($request->all());
        return redirect('roles')->with('success', __('alert.create_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
        $role->delete();
        return redirect('roles')->with('success', __('alert.delete_success'));
    }
    public function permission_create(){
        return view('permission.permissionadd');
    }
    public function permission_store(Request $request){
        Permission::create($request->all());
        return  redirect()->back();
    }
}
