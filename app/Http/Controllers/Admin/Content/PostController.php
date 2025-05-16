<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PostRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Content\Post;
use App\Models\Content\PostCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('postCategory')->get();
        return view('admin.content.post.index', compact('posts'));
    }

    public function search(Request $request)
    {
        $posts = Post::where('title', 'LIKE', "%" . $request->search . "%")->orderBy('title')->get();
        return view('admin.content.post.index', compact('posts'));
    }
    public function create()
    {
        $postCategories = PostCategory::all(['name', 'id']);
        // $users = User::all(['name', 'id']);
        return view('admin.content.post.create', compact(['postCategories']));
    }

    public function store(PostRequest $request, ImageService $imageService)
    {

        date_default_timezone_set('Iran');
        $realTimestamp = substr($request['published_at'], 0, 10);
        $request['published_at'] = date("Y-m-d H:i:s", (int) $realTimestamp);
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.content.post.create')->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['image'] = $result;
        }


        $inputs['author_id'] = Auth::user()->id;
        $inputs['tags'] = implode(",", array_values($inputs['tags']));

        $post = Post::create($inputs);
        if($post)
        {
        return redirect()->route('admin.content.post.index')->with('swal-success', 'پست ' . $post->title . '  با موفقیت افزوده شد');
        }
        else{
            return redirect()->route('admin.content.post.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function status(Post $post)
    {
        $post->status = $post->status == 1 ? 2 : 1;
        $result = $post->save();
        if ($result) {
            if ($post->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت ' . $post->name . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت ' . $post->name . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function commentable(Post $post)
    {
        $post->commentable = $post->commentable == 1 ? 2 : 1;
        $result = $post->save();
        if ($result) {
            if ($post->commentable == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'امکان درج نظر  ' . $post->title . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'امکان درج نظر ' . $post->title . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function edit(Post $post)
    {
        $tags = explode(',', $post['tags']);
        $postCategories = PostCategory::all(['name', 'id']);
        return view('admin.content.post.edit', compact(['postCategories', 'post', 'tags']));

    }

    public function update(Post $post, ImageService $imageService, PostRequest $request)
    {

        date_default_timezone_set('Iran');
        $realTimestamp = substr($request['published_at'], 0, 10);
        $request['published_at'] = date("Y-m-d H:i:s", (int) $realTimestamp);
        $inputs = $request->all();
        if ($request->hasFile('image')) {

            if (!empty($post->image)) {
                $imageService->deleteDirectoryAndFiles($post->image['directory']);
            }

            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
            $result = $imageService->createIndexAndSave($request->file('image'));

            if ($result === false) {
                return redirect()->route('admin.content.post.edit', $post->id)->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($post->image)) {
                $image = $post->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }


        $inputs['author_id'] = Auth::user()->id;
        $inputs['tags'] = implode(",", array_values($inputs['tags']));

        $result = $post->update($inputs);
        if($result)
        {
        return redirect()->route('admin.content.post.index')->with('swal-success', 'پست ' . $post->title . ' با موفقیت ویرایش شد');
        }
        else{
            return redirect()->route('admin.content.post.edit', $post->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function destroy(Post $post)
    {
        $result = $post->delete();
        if($result)
        {
            return redirect()->route('admin.content.post.index')->with('swal-success', 'پست '.$post->title.' با موفقیت حذف شد');
        }
        else
        {
            return redirect()->route('admin.content.post.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }
}
