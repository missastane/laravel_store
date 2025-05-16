<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketRequest;
use App\Http\Services\File\FileService;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::orderBy('created_at', 'desc')->whereNull('ticket_id')->simplePaginate(15);
        $title = 'همه تیکت ها';
        return view('admin.ticket.index', compact('tickets', 'title'));
    }

    public function search(Request $request)
    {
        $title = 'جستجوی تیکت ها';
        $tickets = Ticket::where('subject', 'LIKE', "%" . $request->search . "%")->orderBy('subject')->get();
        return view('admin.ticket.index', compact('tickets', 'title'));
    }
    public function newTickets()
    {
        $tickets = Ticket::where('seen', 2)->orderBy('created_at', 'desc')->simplePaginate(15);
        foreach ($tickets as $ticket) {
            $ticket->seen = 1;
            $result = $ticket->save();
        }
        $title = 'تیکت های جدید';
        return view('admin.ticket.index', compact('tickets', 'title'));
    }
    public function openTickets()
    {
        $tickets = Ticket::where('status', 2)->orderBy('created_at', 'desc')->simplePaginate(15);
        $title = 'تیکت های باز';
        return view('admin.ticket.index', compact('tickets', 'title'));
    }
    public function closeTickets()
    {
        $tickets = Ticket::where('status', 1)->orderBy('created_at', 'desc')->simplePaginate(15);
        $title = 'تیکت های بسته';
        return view('admin.ticket.index', compact('tickets', 'title'));
    }



    public function show(Ticket $ticket)
    {
        return view('admin.ticket.show', compact('ticket'));
    }

    public function change(Ticket $ticket)
    {
        $ticket->status = $ticket->status == 1 ? 2 : 1;
        $result = $ticket->save();
        if ($result) {
            if ($ticket->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'تیکت ' . $ticket->subject . ' با موفقیت بسته شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'تیکت ' . $ticket->subject . ' با موفقیت باز شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function answer(TicketRequest $request, Ticket $ticket,FileService $fileService)
    {
        DB::transaction(function () use ($request, $ticket, $fileService) {
            $inputs = $request->all();
            $inputs['subject'] = $ticket['subject'];
            $inputs['description'] = $request->description;
            $inputs['author'] = 1; //if author is customer == 2,if is admin == 1
            $inputs['seen'] = 1;
            $inputs['ticket_id'] = $ticket['id'];
            $inputs['reference_id'] = auth()->user()->ticketAdmin->id;
            $ticket->update(['reference_id'=> $inputs['reference_id']]);
            // dd( $inputs['reference_id']);
            // dd(auth()->user());
            $inputs['category_id'] = $ticket['category_id'];
            $inputs['priority_id'] = $ticket['priority_id'];
            $inputs['user_id'] = $ticket->user_id;

            $answeredTicket = Ticket::create($inputs);
            if ($request->hasFile('file')) {

                $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'ticket-files');

                $fileService->setFileSize($request->file('file'));
                $fileSize = $fileService->getFileSize();

                // upload file
                $upload = $fileService->moveToPublic($request->file('file'), $request->file('file')->getClientOriginalName());

                // after upload file we should define file format
                $fileFormat = $fileService->getFileFormat();
                $input['file_path'] = $upload;
                $input['file_size'] = $fileSize;
                $input['file_type'] = $fileFormat;
                $input['ticket_id'] = $answeredTicket->id;
                $input['user_id'] = auth()->user()->id;
                $file = TicketFile::create($input);
            }
        });

        return redirect()->route('admin.ticket.index')->with('swal-success', 'پاسخ شما با موفقیت ثبت شد');
    }


}
