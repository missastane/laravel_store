<?php

namespace App\Providers;


use App\Models\Content\Comment;
use App\Models\Market\CartItem;
use App\Models\Market\Category;
use App\Models\Notification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        // Schema::defaultStringLength(191);
        // date_default_timezone_set('Iran');
    // dd(curl_version());
    
        // auth()->loginUsingId(18);
        // DB::listen(function ($query) {
        //     Log::info(
        //         'Query Executed: ' . $query->sql,
        //         ['bindings' => $query->bindings, 'time' => $query->time]
        //     );
        // });
        view()->composer('admin.layouts.header', function ($view) {
            $view->with('unSeenComments', Comment::where('seen', 2)->get());
            $view->with('notifications', Notification::where('read_at', null)->get());
        });


        view()->composer('customer.layouts.header', function ($view) {
            if (Auth::check()) {
                $view->with('cartItems', CartItem::where('user_id', Auth::user()->id)->get());
                $view->with('categories', Category::all());
            }else{
                $view->with('cartItems', null);
                $view->with('categories', Category::all());
            }
        });

    }
}
