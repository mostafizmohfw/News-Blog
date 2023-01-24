<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PhotoUploadController;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    final public function index():Application|Factory|View
    {
        $query = Post::with('category', 'sub_category', 'user', 'tag')->latest();
        if (Auth::user()->role === User::USER){
            $query->where('user_id' , Auth::id());
        }
        $posts =$query->paginate(20);
        return view('backend.modules.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 1)->pluck('name', 'id');
        $tags = Tag::where('status', 1)->select('name', 'id')->get();
        return view('backend.modules.post.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostCreateRequest $request)
    {
        $post_data = $request->except(['tag_ids', 'photo', 'slug']);
        $post_data['slug'] = Str::slug($request->input('slug'));
        $post_data['user_id'] = Auth::user()->id;
        $post_data['is_approved'] = 1;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = Str::slug($request->input('slug'));
            $height = 400;
            $width = 1000;
            $thumb_height = 150;
            $thumb_width = 300;
            $path = 'image/post/original/';
            $thumb_path = 'image/post/thumbnail/';

            $image_name = PhotoUploadController::imageUpload($name, $height, $width, $path, $file);
            $post_data['photo'] = url('image/post/thumbnail/'.$image_name);
            PhotoUploadController::imageUpload($name, $thumb_height, $thumb_width, $thumb_path, $file);
        }

        $post = Post::create($post_data);
        $post->tag()->attach($request->input('tag_ids'));
        session()->flash('cls', 'success');
        session()->flash('msg', 'Post Created Successfully');
        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if (Auth::user()->role == User::USER && $post->user_id != Auth::id()){
            abort(403, 'Unauthorized');
        }
        $post->load(['category', 'sub_category', 'user', 'tag']);
        return view('backend.modules.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::where('status', 1)->pluck('name', 'id');
        $tags = Tag::where('status', 1)->select('name', 'id')->get();
        $selected_tags = DB::table('post_tag')->where('post_id', $post->id)->pluck('tag_id')->toArray();
//        $post->load('tag');
//        $selected_tags = $post->tag->pluck('id')->toArray();

        return view('backend.modules.post.edit', compact('post', 'categories', 'tags', 'selected_tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $post_data = $request->except(['tag_ids', 'photo', 'slug']);
        $post_data['slug'] = Str::slug($request->input('slug'));
        $post_data['user_id'] = Auth::user()->id;
        $post_data['is_approved'] = 1;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = Str::slug($request->input('slug'));
            $height = 400;
            $width = 1000;
            $thumb_height = 150;
            $thumb_width = 300;
            $path = 'image/post/original/';
            $thumb_path = 'image/post/thumbnail/';
            PhotoUploadController::imageUnlink($path, $post->photo);
            PhotoUploadController::imageUnlink($thumb_path, $post->photo);
            $image_name = PhotoUploadController::imageUpload($name, $height, $width, $path, $file);
            $post_data['photo'] = url('image/post/thumbnail/'.$image_name);
            PhotoUploadController::imageUpload($name, $thumb_height, $thumb_width, $thumb_path, $file);
        }

        $post->update($post_data);
        $post->tag()->sync($request->input('tag_ids'));
        session()->flash('cls', 'success');
        session()->flash('msg', 'Post Updated Successfully');
        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $path = 'image/post/original/';
        $thumb_path = 'image/post/thumbnail/';
        PhotoUploadController::imageUnlink($path, $post->photo);
        PhotoUploadController::imageUnlink($thumb_path, $post->photo);
        $post->delete();
        session()->flash('cls', 'warning');
        session()->flash('msg', 'Post Deteted Successfully');
        return redirect()->route('post.index');
    }
}
