<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PageRequest;
use App\Models\Content\Page;
use Illuminate\Http\Request;


class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.content.page.index', compact('pages'));
    }

    public function search(Request $request)
    {
        $pages = Page::where('title', 'LIKE', "%" . $request->search . "%")->orderBy('title')->get();
        return view('admin.content.page.index', compact('pages'));
    }
    public function create()
    {
        return view('admin.content.page.create');
    }

    public function store(PageRequest $request)
    {
        // dd($request);
        $inputs = $request->all();
        $inputs['tags'] = implode(",", array_values($inputs['tags']));

        $page = Page::create($inputs);
        if($page)
        {
        return redirect()->route('admin.content.page.index')->with('swal-success',  'صفحه '.$page->title.' با موفقیت افزوده شد');
        }
        else{
            return redirect()->route('admin.content.page.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function status(Page $page)
    {
        $page->status = $page->status == 1 ? 2 : 1;
        $result = $page->save();
        if ($result) {
            if ($page->status == 1) {
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
    public function show(Page $page)
    {
       
        return view('admin.content.page.show', compact(['page']));
    }
    public function edit(Page $page)
    {
        $tags = explode(',', $page['tags']);
        return view('admin.content.page.edit', compact(['page', 'tags']));
        
    }

    public function update(PageRequest $request,Page $page)
    {
        $inputs = $request->all();
        $inputs['tags'] = implode(",", array_values($inputs['tags']));

        $result = $page->update($inputs);
        if($result)
        {
        return redirect()->route('admin.content.page.index')->with('swal-success', 'صفحه '.$page->title.' با موفقیت ویرایش شد');
        }
        else{
            return redirect()->route('admin.content.page.edit', $page->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function destroy(Page $page)
    {
        
        $result = $page->delete();
        if($result)
        {
            return redirect()->route('admin.content.page.index')->with('swal-success', 'صفحه '.$page->title.' با موفقیت حذف شد');
        }
        else
        {
            return redirect()->route('admin.content.page.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }
}
