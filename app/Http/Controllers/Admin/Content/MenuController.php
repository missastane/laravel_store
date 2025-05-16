<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\MenuRequest;
use App\Models\Content\Menu;
use Illuminate\Http\Request;


class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.content.menu.index', compact('menus'));
    }

    public function search(Request $request)
    {
        $menus = Menu::where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        return view('admin.content.menu.index', compact('menus'));
    }
    public function create()
    {
        $parentMenus = Menu::where('parent_id', null)->get(['name', 'id']);
        return view('admin.content.menu.create', compact('parentMenus'));
    }

    public function store(MenuRequest $request)
    {
         // dd($request);
         $inputs = $request->all();
         $menu = Menu::create($inputs);
         if($menu)
         {
         return redirect()->route('admin.content.menu.index')->with('swal-success',  'منوی '.$menu->name.' با موفقیت افزوده شد');
         }
         else{
             return redirect()->route('admin.content.menu.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
         }
    }
    public function status(Menu $menu)
    {
        $menu->status = $menu->status == 1 ? 2 : 1;
        $result = $menu->save();
        if ($result) {
            if ($menu->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' =>  'وضعیت با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }
    public function edit(Menu $menu)
    {
        $parentMenus = Menu::where('parent_id', null)->get(['name', 'id'])->except($menu->id);
        return view('admin.content.menu.edit', compact(['parentMenus', 'menu']));
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $inputs = $request->all();
        $result = $menu->update($inputs);
        if($result)
        {
        return redirect()->route('admin.content.menu.index')->with('swal-success', 'منوی '.$menu->name.' با موفقیت ویرایش شد');
        }
        else{
            return redirect()->route('admin.content.menu.edit', $menu->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function destroy(Menu $menu)
    {
         
        $result = $menu->delete();
        if($result)
        {
            return redirect()->route('admin.content.menu.index')->with('swal-success', 'منوی '.$menu->name.' با موفقیت حذف شد');
        }
        else
        {
            return redirect()->route('admin.content.menu.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }
}
