<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\PermissionRequest;
use App\Models\User\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.user.permission.index', compact('permissions'));
    }
    public function search(Request $request)
    {
        $permissions = Permission::where('name', 'LIKE', "%" . $request->search . "%")->orWhere('description', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        return view('admin.user.permission.index', compact('permissions'));
    }
    public function create()
    {
        return view('admin.user.permission.create');
    }

    public function store(PermissionRequest $request)
    {
        $inputs = $request->all();
        $permission= Permission::create($inputs);
        if($permission)
        {
        return redirect()->route('admin.user.permission.index')->with('swal-success', 'دسترسی با نام ' . $permission->name . '  با موفقیت افزوده شد');
        }
        else{
            return redirect()->route('admin.user.permission.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function status(Permission $permission)
    {
        $permission->status = $permission->status == 1 ? 2 : 1;
        $result = $permission->save();
        if ($result) {
            if ($permission->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت ' . $permission->name . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت ' . $permission->name . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function edit(Permission $permission)
    {
        return view('admin.user.permission.edit', ['permission' => $permission]);
    }

    public function update(PermissionRequest $request,Permission $permission)
    {
        $inputs = $request->all();
        $result = $permission->update($inputs);
        if($result)
        {
        return redirect()->route('admin.user.permission.index')->with('swal-success', 'دسترسی با نام ' . $permission->name . '  با موفقیت ویرایش شد');
        }
        else{
            return redirect()->route('admin.user.permission.edit', $permission->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function destroy(Permission $permission)
    {
        $result = $permission->delete();
        if($result)
        {
        return redirect()->route('admin.user.permission.index')->with('swal-success', 'دسترسی با نام ' . $permission->name . '  با موفقیت حذف شد');
        }
        else{
            return redirect()->route('admin.user.permission.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }
}
