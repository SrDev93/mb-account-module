<?php

namespace Modules\Account\Http\Controllers;

use App\Models\Brand;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $roles = Role::all();

        return view('account::front.role_permission.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $brands = Brand::all();

        return view('account::front.role_permission.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|string',
            'permission' => 'required|array|min:1',
            "permission.*"  => "required|string|distinct",
        ]);

        try{
            $role = Role::create(['name' => $request->role, 'brand_id' => $request->brand_id]);

            foreach($request->permission as $permission){
                $perm = Permission::where('name' , $permission)->first();
                if(!$perm){
                    $perm = Permission::create(['name' => $permission]);
                }

                $role->permissions()->attach($perm);
            }

            return redirect()->route('admin.role-permission.index')->with('flash_message', 'با موفقیت ثبت شد');
        }catch (\Exception $e){
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Role $role_permission)
    {
        $brands = Brand::all();
        $permissions = $role_permission->permissions->pluck('name')->toArray();
        return view('account::front.role_permission.edit',compact('role_permission','permissions', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Role $role_permission)
    {
        $request->validate([
            'role' => 'required|string',
            'permission' => 'required|array|min:1',
            "permission.*"  => "required|string|distinct",
        ]);

        try{
            $role_permission->update(['name' => $request->role, 'brand_id' => $request->brand_id]);

//            $role_permission->permissions()->delete();

            $perm_array = [];
            foreach($request->permission as $permission){
                $perm = Permission::where('name' , $permission)->first();
                if(!$perm){
                    $perm = Permission::create(['name' => $permission]);
                }

                    array_push($perm_array, $perm->id);
//                $role_permission->permissions()->attach($perm);
            }

            $permissions = Permission::whereIn('id', $perm_array)->get();
            $role_permission->permissions()->sync($permissions);

            return redirect()->route('admin.role-permission.index')->with('flash_message', 'با موفقیت ثبت شد');
        }catch (\Exception $e){
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Role $role_permission)
    {
        try{
            $role_permission->delete();

            return redirect()->route('admin.role-permission.index')->with('flash_message', 'با موفقیت ثبت شد');
        }catch (\Exception $e){
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }
}
