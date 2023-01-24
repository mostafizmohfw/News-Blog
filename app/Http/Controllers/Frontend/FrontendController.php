<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PostCountController;
use App\Models\Category;
use App\Models\Post;
use App\Models\SubCategory;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    public function index()
    {
        $query = Post::with('category', 'sub_category', 'tag', 'user')->where('is_approved', 1)->where('status', 1);
        $posts = $query->latest()->take(5)->get();
        $slider_posts = $query->inRandomOrder()->take(6)->get();
        return view('frontend.modules.index', compact('posts', 'slider_posts'));
    }

    public function all_post()
    {
        $posts = Post::with('category', 'sub_category', 'tag', 'user')->where('is_approved', 1)->where('status', 1)->latest()->paginate(10);
        $title = 'All Post';
        $sub_title = 'View All Post List';
        return view('frontend.modules.all_post', compact('posts', 'title', 'sub_title'));
    }

    public function search(Request $request)
    {
        $posts = Post::with('category', 'sub_category', 'tag', 'user')
            ->where('is_approved', 1)
            ->where('status', 1)
            ->where('title', 'like', '%' . $request->input('search') . '%')
            ->latest()
            ->paginate(10);
        $title = 'View Search Result';
        $sub_title = $request->input('search');
        return view('frontend.modules.all_post', compact('posts', 'title', 'sub_title'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            $posts = Post::with('category', 'sub_category', 'tag', 'user')
                ->where('is_approved', 1)
                ->where('status', 1)
                ->where('category_id', $category->id)
                ->latest()
                ->paginate(10);
        }

        $title = $category->name;
        $sub_title = 'Post By Category';
        return view('frontend.modules.all_post', compact('posts', 'title', 'sub_title'));
    }


    public function sub_category($slug, $sub_slug)
    {
        $sub_category = SubCategory::where('slug', $sub_slug)->first();
        if ($sub_category) {
            $posts = Post::with('category', 'sub_category', 'tag', 'user')
                ->where('is_approved', 1)
                ->where('status', 1)
                ->where('sub_category_id', $sub_category->id)
                ->latest()
                ->paginate(10);
        }

        $title = $sub_category->name;
        $sub_title = 'Post By Sub Category';
        return view('frontend.modules.all_post', compact('posts', 'title', 'sub_title'));
    }

    public function tag(string $slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        $post_ids = DB::table('post_tag')->where('tag_id', $tag->id)->distinct('post_id')->pluck('post_id');

        if ($tag) {
            $posts = Post::with('category', 'sub_category', 'tag', 'user')
                ->where('is_approved', 1)
                ->where('status', 1)
                ->whereIn('id', $post_ids)
                ->latest()
                ->paginate(20);
        }
        $title = $tag->name;
        $sub_title = 'Post By Tag';
        return view('frontend.modules.all_post', compact('posts', 'title', 'sub_title'));
    }

    /**
     * @param string $slug
     * @return Application|Factory|View
     */
    final public function single(string $slug): Application|Factory|View
    {
        $post = Post::with('category', 'sub_category', 'tag', 'user', 'comment', 'comment.user', 'comment.replay', 'post_read_count')
            ->where('is_approved', 1)
            ->where('status', 1)
            ->where('slug', $slug)
            ->firstOrFail();
        return view('frontend.modules.single', compact('post'));
    }


    final public function contact_us()
    {
        return view('frontend.modules.contact_us');
    }

    /**
     * @param int $post_id
     * @return void
     */
    final public function postReadCount(int $post_id):void
    {
//        $postCount = new PostCountController();
//        $postCount->post_id = $post_id;
//        $postCount->postReadCount();

       (new PostCountController($post_id))->postReadCount();
    }

}
