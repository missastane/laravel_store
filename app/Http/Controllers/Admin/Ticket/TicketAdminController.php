<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Ticket\TicketAdmin;
use App\Models\User;
use Illuminate\Http\Request;

class TicketAdminController extends Controller
{
    public function index()
    {
        $admins = User::where('user_type',1)->orderBy('created_at')->simplePaginate(15);
        return view('admin.ticket.admin.index', compact('admins'));
    }

    public function search(Request $request)
    {
        $admins = User::where('user_type', 1)->where(function($query) use($request){
            $query->where('first_name', 'LIKE', "%" . $request->search . "%")->orWhere('last_name', 'LIKE', "%" . $request->search . "%");
        })->orderBy('last_name')->get();
        return view('admin.ticket.admin.index', compact('admins'));
    }

    public function set(User $admin)
    {
      
       $result = TicketAdmin::where('user_id', $admin->id)->first() ? TicketAdmin::where('user_id', $admin->id)->forceDelete() : TicketAdmin::create([
            'user_id'=> $admin->id
        ]);
        
        if($result)
        {
            return redirect()->route('admin.ticket.admin.index')->with('swal-success', 'تغغیرات با موفقیت صورت گرفت');
        }
        else
        {
            return redirect()->route('admin.ticket.admin.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
        
    }
}
