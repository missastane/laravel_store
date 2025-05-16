<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\AdminUserRequest;
use App\Http\Services\Image\ImageService;
use App\Models\User;
use App\Models\User\Permission;
use App\Models\User\Role;
use Hash;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('user_type', 1)->orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.user.admin-user.index', compact('admins'));
    }
    public function search(Request $request)
    {
        $admins = User::where('user_type', 1)->where(function ($query) use ($request) {
            $query->where('first_name', 'LIKE', "%" . $request->search . "%")->orWhere('last_name', 'LIKE', "%" . $request->search . "%");
        })->with('roles:id,name', 'permissions:id,name')->orderBy('last_name')->get();
        return view('admin.user.admin-user.index', compact('admins'));
    }
    
    public function create()
    {
        return view('admin.user.admin-user.create');
    }

    public function store(AdminUserRequest $request,ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'admins');
            $result = $imageService->save($request->file('profile_photo_path'));
            if ($result === false) {
                return redirect()->route('admin.user.admin-user.create')->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['profile_photo_path'] = $result;
        }
        $inputs['password'] = Hash::make($request['password']);
        $inputs['user_type'] = 1;
        $inputs['status'] = 1;
        $adminUser = User::create($inputs);
        if($adminUser)
        {
            return redirect()->route('admin.user.admin-user.index')->with('swal-success', $adminUser->fullName.' با موفقیت افزوده شد');
        }
        else
        {
            return redirect()->route('admin.user.admin-user.index')->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function status(User $admin)
    {
       
        $admin->status = $admin->status == 1 ? 2 : 1;
        $result = $admin->save();
        if ($result) {
            if ($admin->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت ' . $admin->fullName . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت ' . $admin->fullName . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function activation(User $admin)
    {
       
       $admin->activation = $admin->activation == 1 ? 2 : 1;
        $result = $admin->save();
        if ($result) {
            if ($admin->activation == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت فعالسازی ' . $admin->fullName . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت فعالسازی ' . $admin->fullName . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }


    public function edit(User $admin)
    {
        return view('admin.user.admin-user.edit', compact('admin'));
    }

    public function update(AdminUserRequest $request, ImageService $imageService, User $admin)
    {
       
        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {
            if(!empty($admin->profile_photo_path))
            {
                $imageService->deleteImage($admin->profile_photo_path);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'admins');
            $result = $imageService->save($request->file('profile_photo_path'));
            if ($result === false) {
                return redirect()->route('admin.user.admin-user.edit', $admin->id)->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['profile_photo_path'] = $result;
        }       
        
        $update =$admin->update($inputs);
        if($update)
        {
            return redirect()->route('admin.user.admin-user.index')->with('swal-success', $admin->fullName.' با موفقیت ویرایش شد');
        }
        else
        {
            return redirect()->route('admin.user.admin-user.edit', $admin->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function destroy(User $admin)
    {
        $result = $admin->delete();
        if ($result) {
            return redirect()->route('admin.user.admin-user.index')->with('swal-success',  $admin->fullName . ' با موفقیت حذف شد');
        }
        return redirect()->route('admin.user.admin-user.index')->with('swal-error', 'مشکلی پیش آمده است. لطفا مجددا امتحان کنید');
    }

    public function roles(User $admin)
    {
        $roles = Role::all();
        return view('admin.user.admin-user.roles', compact('admin', 'roles'));
    }

    public function rolesStore(User $admin, Request $request)
    {
        $validated = $request->validate([
            'roles' => 'nullable|exists:roles,id|array',
            'g-recaptcha-response' => 'recaptcha',
        ]);

        $admin->roles()->sync($request->roles);
        return redirect()->route('admin.user.admin-user.index')->with('swal-success',   ' نقش های ادمین با موفقیت ویرایش شد');
        
    }

    public function permissions(User $admin)
    {
        $permissions = Permission::all();
        return view('admin.user.admin-user.permissions', compact('admin', 'permissions'));
    }

    public function permissionsStore(User $admin, Request $request)
    {
        $validated = $request->validate([
            'permissions' => 'nullable|exists:permissions,id|array',
            'g-recaptcha-response' => 'recaptcha',
        ]);

        $admin->permissions()->sync($request->permissions);
        return redirect()->route('admin.user.admin-user.index')->with('swal-success',   ' دسترسی های ادمین با موفقیت ویرایش شد');
        
    }
}
