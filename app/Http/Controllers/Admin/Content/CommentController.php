<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\CommentRequest;
use App\Models\Content\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $unSeenComments = Comment::where('seen', 2)->get();
        foreach ($unSeenComments as $unSeenComment) {
            $unSeenComment->seen = 1;
            $unSeenComment->save();
        }
        $comments = Comment::where('commentable_type', 'App\Models\Content\Post')->orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.content.comment.index', compact('comments'));
    }

    public function search(Request $request)
    {
        $comments = Comment::where('commentable_type', 'App\Models\Content\Post')->where('body', 'LIKE', "%" . $request->search . "%")->get();
        return view('admin.content.comment.index', compact('comments'));
    }

    public function show(Comment $comment)
    {
        return view('admin.content.comment.show', compact('comment'));
    }

    public function answer(CommentRequest $request, Comment $comment)
    {
        if ($comment->parent_id == null) {
            $inputs = $request->all();
            $inputs['author_id'] = Auth::user()->id;
            $inputs['parent_id'] = $comment->id;
            $inputs['commentable_id'] = $comment->commentable_id;
            $inputs['commentable_type'] = $comment->commentable_type;
            $inputs['status'] = 1;
            $inputs['approved'] = 1;
            $answer_comment = Comment::create($inputs);
            if ($answer_comment) {
                return redirect()->route('admin.content.comment.index')->with('swal-success', 'پاسخ نظر با موفقیت افزوده شد');
            } else {
                return redirect()->route('admin.content.comment.show', $comment->id)->with('swal-error', 'ارسال پاسخ با خطا مواجه شد. لطفا دوباره امتحان کنید');
            }
        }
        return redirect()->route('admin.content.comment.index')->with('swal-error', 'خطا');
    }

    public function status(Comment $comment)
    {
        $comment->status = $comment->status == 1 ? 2 : 1;
        $result = $comment->save();
        if ($result) {
            if ($comment->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'نظر با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'نظر با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }


    public function approved(Comment $comment)
    {
        $comment->approved = $comment->approved == 1 ? 2 : 1;
        $result = $comment->save();
        if ($result) {
            if ($comment->approved == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'نظر با موفقیت تأیید شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'تأییدیه نظر غیرغعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }
}
