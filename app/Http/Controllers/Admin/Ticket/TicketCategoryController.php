<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketCategoryRequest;
use App\Models\Ticket\TicketCategory;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{
    public function index()
    {
        $ticketCategories = TicketCategory::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.ticket.category.index', compact('ticketCategories'));
    }
    public function search(Request $request)
    {
        $ticketCategories = TicketCategory::where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        return view('admin.ticket.category.index', compact('ticketCategories'));
    }
    public function create()
    {
        return view('admin.ticket.category.create');
    }

    public function store(TicketCategoryRequest $request)
    {
        $inputs = $request->all();
        $ticketCategory = TicketCategory::create($inputs);
        if($ticketCategory)
        {
        return redirect()->route('admin.ticket.category.index')->with('swal-success', 'دسته ' . $ticketCategory->name . '  با موفقیت افزوده شد');
        }
        else{
            return redirect()->route('admin.ticket.category.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function status(TicketCategory $ticketCategory)
    {
        $ticketCategory->status = $ticketCategory->status == 1 ? 2 : 1;
        $result = $ticketCategory->save();
        if ($result) {
            if ($ticketCategory->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت ' . $ticketCategory->name . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت ' . $ticketCategory->name . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function edit(TicketCategory $ticketCategory)
    {
        return view('admin.ticket.category.edit', compact(['ticketCategory']));
    }

    public function update(TicketCategory $ticketCategory, TicketCategoryRequest $request)
    {
        $inputs = $request->all();
        $result = $ticketCategory->update($inputs);
        if($result)
        {
        return redirect()->route('admin.ticket.category.index')->with('swal-success', 'دسته ' . $ticketCategory->title . ' با موفقیت ویرایش شد');
        }
        else{
            return redirect()->route('admin.ticket.category.edit', $ticketCategory->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function destroy(TicketCategory $ticketCategory)
    {
        $result = $ticketCategory->delete();
        if($result)
        {
            return redirect()->route('admin.ticket.category.index')->with('swal-success', 'دسته '.$ticketCategory->name.' با موفقیت حذف شد');
        }
        else
        {
            return redirect()->route('admin.ticket.category.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }
}
