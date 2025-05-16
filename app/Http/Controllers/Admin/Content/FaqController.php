<?php

namespace App\Http\Controllers\Admin\Content;
use App\Http\Requests\Admin\Content\FaqRequest;
use App\Models\Content\Faq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('created_at')->simplePaginate(15);
        return view('admin.content.faq.index', compact('faqs'));
    }

    public function search(Request $request)
    {
        $faqs = Faq::where('question', 'LIKE', "%" . $request->search . "%")->orWhere('answer', 'LIKE', "%" . $request->search . "%")->orderBy('question')->get();
        return view('admin.content.faq.index', compact('faqs'));
    }
    public function create()
    {
        return view('admin.content.faq.create');
    }

    public function store(FaqRequest $request)
    {
        $inputs = $request->all();
        $inputs['tags'] = implode(",", array_values($inputs['tags']));

        $faq = Faq::create($inputs);
        if($faq)
        {
        return redirect()->route('admin.content.faq.index')->with('swal-success', 'سؤال با موفقیت افزوده شد');
        }
        else{
            return redirect()->route('admin.content.faq.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }


    public function show(Faq $faq)
    {
       
        return view('admin.content.faq.show', compact(['faq']));
    }

    public function status(Faq $faq)
    {
        $faq->status = $faq->status == 1 ? 2 : 1;
        $result = $faq->save();
        if ($result) {
            if ($faq->status == 1) {
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
    public function edit(Faq $faq)
    {
        $tags = explode(',', $faq['tags']);
        return view('admin.content.faq.edit', compact(['faq', 'tags']));
    }

    public function update(FaqRequest $request,Faq $faq)
    {
        $inputs = $request->all();
        $inputs['tags'] = implode(",", array_values($inputs['tags']));

        $reseult = $faq->update($inputs);
        if($reseult)
        {
        return redirect()->route('admin.content.faq.index')->with('swal-success', 'سؤال با موفقیت ویرایش شد');
        }
        else{
            return redirect()->route('admin.content.faq.edit', $faq->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function destroy(Faq $faq)
    {
        $result = $faq->delete();
        if($result)
        {
            return redirect()->route('admin.content.faq.index')->with('swal-success', 'سؤال موفقیت حذف شد');
        }
        else
        {
            return redirect()->route('admin.content.faq.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }
}
