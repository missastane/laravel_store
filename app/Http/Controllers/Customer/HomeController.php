<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Content\Banner;
use App\Models\Content\Page;
use App\Models\Market\Brand;
use App\Models\Market\Category;
use App\Models\Market\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home()
    {
        
        $slideShowImages = Banner::where('position', 0)->where('status', 1)->get();
        $topBanners = Banner::where('position', 1)->where('status', 1)->take(2)->get();
        $middleBanners = Banner::where('position', 2)->where('status', 1)->take(2)->get();
        $bottomBanner = Banner::where('position', 3)->where('status', 1)->first();
        $brands = Brand::all();
        $mostVisitedProducts = Product::orderBy('view', 'desc')->take(10)->get();
        $offerProducts = Product::latest()->take(10)->get();
        return view('customer.home', compact(['slideShowImages', 'topBanners', 'middleBanners', 'bottomBanner', 'brands', 'mostVisitedProducts', 'offerProducts']));
    }




    public function products(Request $request, Category $category = null)
    {
        // dd($request->brands);
        // get brands
        $brands = Brand::orderBy('original_name')->get();

        // set category
        if ($category)
            $productModel = $category->products();
        else
            $productModel = new Product();

        // get categories
        $categories = Category::whereNull('parent_id')->get();
        // validate requests
        $request->validate([
            'min_price' => 'nullable|numeric',
            'max_price' => 'nullable|numeric',
            'brands.*' => 'nullable|exists:brands,id',
        ]);

        // switch for set sort filtering
        switch ($request->sort) {
            case "1":
                $colomn = "created_at";
                $direction = "DESC";
                break;
            case "2":
                $colomn = "price";
                $direction = "DESC";
                break;
            case "3":
                $colomn = "price";
                $direction = "ASC";
                break;
            case "4":
                $colomn = "view";
                $direction = "DESC";
                break;
            case "5":
                $colomn = "sold_number";
                $direction = "DESC";
                break;
            default:
                $colomn = "created_at";
                $direction = "ASC";

        }
        // get queries
        if ($request->search) {
            $query = $productModel->where('name', 'LIKE', "%" . $request->search . "%")->orderBy($colomn, $direction);
        } else {
            $query = $productModel->orderBy($colomn, $direction);
        }
        $products = $request->max_price && $request->min_price ? $query->whereBetween('price', [$request->min_price, $request->max_price]) :
            $query->when($request->min_price, function ($query) use ($request) {
                $query->where('price', '>=', $request->min_price)->get();
            })->when($request->max_price, function ($query) use ($request) {
                $query->where('price', '<=', $request->max_price)->get();
            })->when(!($request->max_price && $request->min_price), function ($query) {
                $query->get();
            });
        $products = $products->when($request->brands, function () use ($request, $products) {
            $products->whereIn('brand_id', $request->brands);
        });

        $products = $products->paginate(12);
        $products->appends($request->query());
        return view('customer.market.products', compact('products', 'brands', 'categories'));
    }

    public function page(Page $page)
    {
        return view('customer.page', compact('page'));
    }

    public function autocomplete(Request $request)
    {
        if ($request->search) {
            $query = $request->search;
            $data = Product::select('category_id', 'name', 'slug')
                ->where('name', 'like', '%' . $query . '%')
                ->with('category')
                ->get()
                ->groupBy('category.name');
            $output = '<section class="search-result-title">نتایج جستجو برای <span class="search-words">' . $query . ' ' . '</span><span class="search-result-type">در دسته بندی ها</span></section>';

           
            if (count($data) > 0) {
                foreach ($data as $key => $value) {
                    $output .= '<section class="border-bottom p-1"><section class="text-danger text-bold">در دسته ' . $key . '</section>';
                    foreach ($value as $product) {
                        $output .= '<section class="search-result-item autocomplete-result"><a class="text-decoration-none" href="' . url('/product', $product->slug) . '"><i class="fa fa-link"></i>' . ' ' . $product->name . '</a></section>';
                    }
                    $output .= '</section>';
                   
                }
            } else {
                $output .= '<section class="search-result-item"><span class="search-no-result">موردی یافت نشد</span></section>';
            }
            echo $output;
        }

    }

}
