<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\Permission_RoleRequest;
use App\Http\Requests\Admin\User\RoleRequest;
use App\Models\User\Permission;
use App\Models\User\Permission_Role;
use App\Models\User\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.user.role.index', compact('roles'));
    }

    public function search(Request $request)
    {
        $roles = Role::where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        return view('admin.user.role.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.user.role.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $inputs = $request->all();
        $role = Role::create($inputs);
        $inputs['permission_id'] = $inputs['permission_id'] ?? [];
        $role->permissions()->sync($inputs['permission_id']);
        if ($role) {
            return redirect()->route('admin.user.role.index')->with('swal-success', 'نقش ' . $role->name . '  با موفقیت افزوده شد');
        } else {
            return redirect()->route('admin.user.role.crete')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function edit(Role $role)
    {
        return view('admin.user.role.edit', compact('role'));
    }

    public function update(Role $role, RoleRequest $request)
    {
        $inputs = $request->all();
        $update = $role->update($inputs);
        if ($update) {
            return redirect()->route('admin.user.role.index')->with('swal-success', 'نقش ' . $role->name . '  با موفقیت ویرایش شد');
        } else {
            return redirect()->route('admin.user.role.edit', $role->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function permissionForm(Role $role)
    {
        $allPermissions = Permission::all();
        $permissions = $role->permissions()->pluck('id')->toArray();
        return view('admin.user.role.set-permission', compact(['role', 'allPermissions', 'permissions']));
    }
    public function permission(Role $role, RoleRequest $request)
    {
        $inputs = $request->all();
        $inputs['permission_id'] = $inputs['permission_id'] ?? [];
        $result = $role->permissions()->sync($inputs['permission_id']);
        if ($result) {
            return redirect()->route('admin.user.role.index')->with('swal-success', 'دتسزسی های نقش ' . $role->name . '  با موفقیت ویرایش شد');
        } else {
            return redirect()->route('admin.user.role.permission-form', $role->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function destroy(Role $role)
    {
        $result = $role->delete();
        if ($result) {
            return redirect()->route('admin.user.role.index')->with('swal-success', 'نقش ' . $role->name . '  با موفقیت حذف شد');
        } else {
            return redirect()->route('admin.user.role.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }
}
