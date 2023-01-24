<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        $categories = Category::with('sub_categories')->where('status', 1)->orderBy('order_by', 'asc')->get();
        $tags = Tag::where('status', 1)->orderBy('order_by', 'asc')->get();
        $recent_posts= Post::where('is_approved', 1)->where('status', 1)->latest()->take(5)->get();
        View::share(['categories' => $categories, 'tags'=>$tags, 'recent_posts' => $recent_posts]);
    }
}
