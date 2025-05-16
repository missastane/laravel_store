<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CustomerRequest;
use App\Http\Services\Image\ImageService;
use App\Models\User;
use App\Notifications\NewUserRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('user_type',2)->orderBy('created_at','desc')->paginate(15);
        return view('admin.user.customer.index', compact('customers'));
    }

    public function search(Request $request)
    {
        $customers = User::where('user_type', 2)->where(function ($query) use ($request) {
            $query->where('first_name', 'LIKE', "%" . $request->search . "%")->orWhere('last_name', 'LIKE', "%" . $request->search . "%");
        })->orderBy('last_name')->get();
        return view('admin.user.customer.index', compact('customers'));
    }
    public function create()
    {
        return view('admin.user.customer.create');
    }

    public function store(CustomerRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'customers');
            $result = $imageService->save($request->file('profile_photo_path'));
            if ($result === false) {
                return redirect()->route('admin.user.customer.create')->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['profile_photo_path'] = $result;
        }
        $inputs['password'] = Hash::make($request['password']);
        $inputs['user_type'] = 2;
        $inputs['status'] = 1;
        $customer = User::create($inputs);
        $details = ['message' => 'یک کاربر جدید در سایت ثبت نام شد'];
        $adminUser = User::find(1);
        $adminUser->notify(new NewUserRegister($details));
        if ($customer) {
            return redirect()->route('admin.user.customer.index')->with('swal-success', $customer->fullName . ' با موفقیت افزوده شد');
        } else {
            return redirect()->route('admin.user.customer.index')->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function status(User $customer)
    {
       
        $customer->status = $customer->status == 1 ? 2 : 1;
        $result = $customer->save();
        if ($result) {
            if ($customer->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت ' . $customer->fullName . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت ' . $customer->fullName . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function activation(User $customer)
    {
       
       $customer->activation = $customer->activation == 1 ? 2 : 1;
        $result = $customer->save();
        if ($result) {
            if ($customer->activation == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت فعالسازی ' . $customer->fullName . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت فعالسازی ' . $customer->fullName . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function edit(User $customer)
    {
        return view('admin.user.customer.edit', compact('customer'));
    }

    public function update(CustomerRequest $request, ImageService $imageService, User $customer)
    {
       
        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {
            if(!empty($customer->profile_photo_path))
            {
                $imageService->deleteImage($customer->profile_photo_path);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'customers');
            $result = $imageService->save($request->file('profile_photo_path'));
            if ($result === false) {
                return redirect()->route('admin.user.customer.edit', $customer->id)->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['profile_photo_path'] = $result;
        }       
        
        $update =$customer->update($inputs);
        if($update)
        {
            return redirect()->route('admin.user.customer.index')->with('swal-success', $customer->fullName.' با موفقیت ویرایش شد');
        }
        else
        {
            return redirect()->route('admin.user.customer.edit', $customer->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function destroy(User $customer)
    {
        $result = $customer->delete();
        if ($result) {
            return redirect()->route('admin.user.customer.index')->with('swal-success',  $customer->fullName . ' با موفقیت حذف شد');
        }
        return redirect()->route('admin.user.customer.index')->with('swal-error', 'مشکلی پیش آمده است. لطفا مجددا امتحان کنید');
    }
}
