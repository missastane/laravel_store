<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketPriorityRequest;
use App\Models\Ticket\TicketPriority;
use Illuminate\Http\Request;

class TicketPriorityController extends Controller
{
    public function index()
    {
        $ticketPriorities = TicketPriority::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.ticket.priority.index', compact('ticketPriorities'));
    }
    public function search(Request $request)
    {
        $ticketPriorities = TicketPriority::where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        return view('admin.ticket.priority.index', compact('ticketPriorities'));
    }
    public function create()
    {
        return view('admin.ticket.priority.create');
    }

    public function store(TicketPriorityRequest $request)
    {
        $inputs = $request->all();
        $ticketPriority = TicketPriority::create($inputs);
        if($ticketPriority)
        {
        return redirect()->route('admin.ticket.priority.index')->with('swal-success', 'اولویت ' . $ticketPriority->name . '  با موفقیت افزوده شد');
        }
        else{
            return redirect()->route('admin.ticket.priority.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function status(TicketPriority $ticketPriority)
    {
        $ticketPriority->status = $ticketPriority->status == 1 ? 2 : 1;
        $result = $ticketPriority->save();
        if ($result) {
            if ($ticketPriority->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت ' . $ticketPriority->name . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت ' . $ticketPriority->name . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function edit(TicketPriority $ticketPriority)
    {
        return view('admin.ticket.priority.edit', compact(['ticketPriority']));
    }

    public function update(TicketPriority $ticketPriority, TicketPriorityRequest $request)
    {
        $inputs = $request->all();
        $result = $ticketPriority->update($inputs);
        if($result)
        {
        return redirect()->route('admin.ticket.priority.index')->with('swal-success', 'اولویت ' . $ticketPriority->title . ' با موفقیت ویرایش شد');
        }
        else{
            return redirect()->route('admin.ticket.priority.edit', $ticketPriority->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function destroy(TicketPriority $ticketPriority)
    {
        $result = $ticketPriority->delete();
        if($result)
        {
            return redirect()->route('admin.ticket.priority.index')->with('swal-success', 'اولویت '.$ticketPriority->name.' با موفقیت حذف شد');
        }
        else
        {
            return redirect()->route('admin.ticket.priority.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }
}
