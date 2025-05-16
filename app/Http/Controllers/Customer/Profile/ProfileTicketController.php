<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Profile\CreateTicketRequest;
use App\Http\Requests\Customer\ProFile\TicketStoreRequest;
use App\Http\Services\File\FileService;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketCategory;
use App\Models\Ticket\TicketFile;
use App\Models\Ticket\TicketPriority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileTicketController extends Controller
{
  public function index()
  {

    if (isset(request()->type) && request()->type == 0) {
      $tickets = auth()->user()->tickets()->where('seen', 2)->whereNull('ticket_id')->orderBy('id', 'desc')->get();
    } else if (isset(request()->type) && request()->type > 0) {
      $tickets = auth()->user()->tickets()->where('status', request()->type)->where('ticket_id', null)->orderBy('id', 'desc')->get();
    } else if (request()->type == null) {
      $tickets = auth()->user()->tickets()->where('ticket_id', null)->orderBy('id', 'desc')->get();
    }
    return view('customer.profile.tickets.tickets', compact('tickets'));
  }

  public function ticketDetails(Ticket $ticket)
  {
    return view('customer.profile.tickets.ticket-datail', compact('ticket'));
  }

  public function ticketAnswer(TicketStoreRequest $request, Ticket $ticket, FileService $fileService)
  {
    DB::transaction(function () use ($request, $ticket, $fileService) {
      $inputs = $request->all();
      $inputs['subject'] = $ticket['subject'];
      $inputs['description'] = $request->description;
      $inputs['seen'] = 2;
      $inputs['ticket_id'] = $ticket['id'];
      $inputs['reference_id'] = $ticket['reference_id'];
      $inputs['category_id'] = $ticket['category_id'];
      $inputs['priority_id'] = $ticket['priority_id'];
      $inputs['user_id'] = Auth::user()->id;
      // dd($inputs);
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

    return redirect()->back()->with('toasr-success', 'پاسخ شما با موفقیت ثبت شد');
  }



  public function ticketCreate()
  {
    $periorities = TicketPriority::all();
    $categories = TicketCategory::all();
    return view('customer.profile.tickets.create-ticket', compact('periorities', 'categories'));
  }

  public function ticketStore(CreateTicketRequest $request, FileService $fileService)
  {
    DB::transaction(function () use ($request, $fileService) {
      // ticket
      $inputs = $request->all();
      $inputs['reference_id'] = null;
      $inputs['user_id'] = Auth::user()->id;
      $ticket = Ticket::create($inputs);

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
        $input['ticket_id'] = $ticket->id;
        $input['user_id'] = auth()->user()->id;
        $file = TicketFile::create($input);
      }
    });
    return to_route('customer.profile.my-tickets')->with('toasr-success', 'تیکت شما با موفقیت ثبت شد');

  }

  
}
