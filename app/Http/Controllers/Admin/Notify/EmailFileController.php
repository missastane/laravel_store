<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\EmailFileRequest;
use App\Http\Services\File\FileService;
use App\Models\Notify\Email;
use App\Models\Notify\EmailFile;
use Illuminate\Http\Request;
use Storage;

class EmailFileController extends Controller
{
    public function index(Email $email)
    {
        return view('admin.notify.email-file.index', compact(['email']));
    }

    public function search(Request $request,Email $email)
    {
        $emailFiles = EmailFile::where('public_mail_id', $email->id)->where('file_type', 'LIKE', "%" . $request->search . "%")->orderBy('file_type')->get();
        $request->session()->put('emailFiles', $emailFiles);
        return view('admin.notify.email-file.index', compact('email'))->with(['emailFiles'=> $emailFiles]);
    }
    public function create(Email $email)
    {
        return view('admin.notify.email-file.create', compact('email'));
    }


    public function status(EmailFile $file)
    {
        $file->status = $file->status == 1 ? 2 : 1;
        $result = $file->save();
        if ($result) {
            if ($file->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت با موفقیت فعال شد'
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

    public function store(EmailFileRequest $request, Email $email, FileService $fileService)
    {
        $inputs = $request->all();
        if ($request->hasFile('file')) {
            $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'email-files');
           
            $fileService->setFileSize($request->file('file'));
            $fileSize = $fileService->getFileSize();
          
            // upload file
            // if the file is very important use MoveToStorage() method to be safe
            if($inputs['path'] == 1)
            {
                $result = $fileService->moveToStorage($request->file('file'), $request->file('file')->getClientOriginalName());
            }
            else
            {
                $result = $fileService->moveToPublic($request->file('file'), $request->file('file')->getClientOriginalName());
            }
            
           
            // after upload file we should define file format
            $fileFormat = $fileService->getFileFormat();
        }
        if ($result === false) {
            return redirect()->route('admin.notify.email-file.index', $email->id)->with('swal-error', 'بارگذاری فایل با خطا مواجه شد');

        }
        $inputs['public_mail_id'] = $email->id;
        $inputs['file_path'] = $result;
        $inputs['file_size'] = $fileSize;
        $inputs['file_type'] = $fileFormat;
        $file = EmailFile::create($inputs);
        if ($file) {
            return redirect()->route('admin.notify.email-file.index', $email->id)->with('swal-success', 'فایل با موفقیت افزوده شد');
        } else {
            return redirect()->route('admin.notify.email-file.create', $email->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function edit(EmailFile $file)
    {
        return view('admin.notify.email-file.edit', compact('file'));
    }

    public function update(EmailFileRequest $request, EmailFile $file, FileService $fileService)
    {
        $inputs = $request->all();
        if ($request->hasFile('file')) {
            if(!empty($file->file_path))
            {
                if(file_exists(storage_path($file->file_path))){
                    $fileService->deleteFile($file->file_path,true);
                }
                if(file_exists(public_path($file->file_path))){
                    $fileService->deleteFile($file->file_path);
                }
            }
            $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'email-files');
           
            $fileService->setFileSize($request->file('file'));
            $fileSize = $fileService->getFileSize();
            // upload file
            // if the file is very important use MoveToStorage() method to be safe
          
            if($inputs['path'] == 1)
            {
                
                $result = $fileService->moveToStorage($request->file('file'), $request->file('file')->getClientOriginalName());
            }
            else
            {
                $result = $fileService->moveToPublic($request->file('file'), $request->file('file')->getClientOriginalName());
            }
            // after upload file we should define file format
            $fileFormat = $fileService->getFileFormat();
            if ($result === false) {
                return redirect()->route('admin.notify.email-file.index', $file->public_mail_id)->with('swal-error', 'بارگذاری فایل با خطا مواجه شد');

            }
            $inputs['file_path'] = $result;
            $inputs['file_size'] = $fileSize;
            $inputs['file_type'] = $fileFormat;
        }
       
        $emailFile = $file->update($inputs);
        if($emailFile)
        {
        return redirect()->route('admin.notify.email-file.index', $file->public_mail_id)->with('swal-success',  'فایل با موفقیت ویرایش شد');
        }
        return redirect()->route('admin.notify.email-file.edit', $file->id)->with('swal-error',  'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
    }
    
    public function destroy(EmailFile $file)
    {
        $result = $file->delete();
        if($file)
        {
        return redirect()->route('admin.notify.email-file.index', $file->public_mail_id)->with('swal-success',  'فایل با موفقیت حذف شد');
        }
        return redirect()->route('admin.notify.email-file.index', $file->public_mail_id)->with('swal-error',  'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
    }

    public function openFile(EmailFile $file)
    {
   
        if(file_exists(storage_path($file->file_path)))
        {
            return response()->file(storage_path($file->file_path));
        }
       elseif(file_exists(public_path($file->file_path)))
        {
            return response()->file($file->file_path);
        }
        else{
            return false;
        }
        
    }
}
