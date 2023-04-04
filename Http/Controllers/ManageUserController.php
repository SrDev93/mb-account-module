<?php

namespace Modules\Account\Http\Controllers;

use App\Models\Brand;
use App\Models\Role;
use Modules\Account\Entities\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Base\Entities\Photo;
use Illuminate\Support\Facades\File;


class ManageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $users = User::all();

        return view('account::front.manage_user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $roles = Role::all();
        $brands = Brand::all();

        return view('account::front.manage_user.create',compact('roles', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'mobile' => 'required|unique:users|max:11',
            'email' => 'required|email',
            'password' => 'required|min:6',
//            'gender' => 'required|in:male,female',
//            'type' => 'required|string',
            'role' => 'nullable|string',
        ]);

        try{

            // create user
            $user = User::create([
                'brand_id' => $request->brand_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if (isset($request->photo)){
                $p = new Photo();
                $p->path = file_store($request->photo, 'assets/uploads/photos/users/','photo_');
                $p->alt = $request->photo_alt;
                $user->photo()->save($p);
            }

            $user->assignRole($request->role);

            return redirect()->route('admin.manage-user.index')->with('flash_message', 'با موفقیت ثبت شد');
        }catch (\Exception $e){
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(User $manage_user)
    {
        $roles = Role::all();
        $brands = Brand::all();

        return view('account::front.manage_user.edit',compact('roles','manage_user', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, User $manage_user)
    {
        $request->validate([
            'FirstName' => 'required|string',
            'LastName' => 'required|string',
            'mobile' => 'required|max:11|unique:users,mobile,'.$manage_user->id,
            'email' => 'required|email',
            'password' => 'nullable|min:6',
            'status' => 'required|in:0,1,-1',
            'role' => 'nullable|string',
        ]);

        try{
            // create user
            $manage_user->update([
                'brand_id' => $request->brand_id,
                'FirstName' => $request->FirstName,
                'LastName' => $request->LastName,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'status' => $request->status,
                'password' => $request->password && $request->password != null ? Hash::make($request->password) : $manage_user->password,
            ]);

            if (isset($request->photo)){
                if ($manage_user->photo){
                    File::delete($manage_user->photo->path);
                    $manage_user->photo->path = file_store($request->photo, 'assets/uploads/photos/users/','photo_');
                    $manage_user->photo->save();
                }else{
                    $p = new Photo();
                    $p->path = file_store($request->photo, 'assets/uploads/photos/users/','photo_');
                    $manage_user->photo()->save($p);
                }
            }else{
                if ($manage_user->photo){
                    $manage_user->photo->save();
                }
            }

            $manage_user->syncRoles($request->role);

            return redirect()->route('admin.manage-user.index')->with('flash_message', 'با موفقیت ثبت شد');
        }catch (\Exception $e){
            dd($e);
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
