<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function bigpost()
    {
        $posts = DB::table('apnokaca_posts')
            ->where('apnokaca_posts.is_deleted', 0)
            ->orderBy('apnokaca_posts.published_at', 'desc')
            ->limit(1)
            ->select(
                'apnokaca_posts.id',
                'apnokaca_posts.blog_title',
                'apnokaca_posts.created_by_alias',
                'apnokaca_posts.intro_image',
                'apnokaca_posts.category',
                DB::raw("TO_CHAR(apnokaca_posts.published_at, 'DD-MM-YYYY') as published_at") 
            )
            ->get();

        return response()->json([
            'status' => 'success',
            'posts' => $posts
        ], 200);
    }


    public function mini_post()
{
    $posts = DB::table('apnokaca_posts')
        ->where('apnokaca_posts.is_deleted', 0)
        ->orderBy('apnokaca_posts.published_at', 'desc')
        ->skip(1) 
        ->take(4) 
        ->select(
            'apnokaca_posts.id',
            'apnokaca_posts.blog_title',
            'apnokaca_posts.created_by_alias',
            'apnokaca_posts.intro_image',
            'apnokaca_posts.category',
            DB::raw("TO_CHAR(apnokaca_posts.published_at, 'DD-MM-YYYY') as published_at") 
        )
        ->get();

    return response()->json([
        'status' => 'success',
        'posts' => $posts
    ], 200);
}

public function getCategories()
{
    $categories = DB::table('apnokaca_categories')
        ->orderBy('created_at', 'desc')
        ->select('name','image','id')
        ->get();

    return response()->json([
        'status' => 'success',
        'categories' => $categories
    ], 200);
}

public function trending_highlight()
{
    $posts = DB::table('apnokaca_posts')
        ->where('apnokaca_posts.is_deleted', 0)
        ->orderBy('apnokaca_posts.published_at', 'desc')
        ->select('apnokaca_posts.blog_title', 'apnokaca_posts.id')
        ->limit(5)
        ->get();

    return response()->json([
        'status' => 'success',
        'posts' => $posts
    ], 200);
}


public function trending_highlight_posts()
{
    $categories = DB::table('apnokaca_posts')
        ->orderBy('created_at', 'desc')
        ->select( 'apnokaca_posts.id',
        'apnokaca_posts.blog_title',
        'apnokaca_posts.created_by_alias',
        'apnokaca_posts.intro_image',
        'apnokaca_posts.category',
        DB::raw("TO_CHAR(apnokaca_posts.published_at, 'DD-MM-YYYY') as published_at") )
        ->limit(8)
        ->get();

    return response()->json([
        'status' => 'success',
        'categories' => $categories
    ], 200);
}

public function getPosts($id)
{
    $posts = DB::table('apnokaca_posts')
        ->where('id', $id)
        ->select(
            'apnokaca_posts.id',
            'apnokaca_posts.blog_title',
            'apnokaca_posts.created_by_alias',
            'apnokaca_posts.image',
            'apnokaca_posts.category',
            'apnokaca_posts.published_at',
            'apnokaca_posts.tags',
            'apnokaca_posts.content',
            'apnokaca_posts.synopsis',
            'apnokaca_posts.blog_heading',  
            // DB::raw("DATE_FORMAT(apnokaca_posts.published_at, '%d-%m-%Y') as published_at")          

            //  DB::raw("DATE_FORMAT(apnokaca_posts.published_at, '%d-%m-%Y') as published_at") 
        )
        ->first();

    if (!$posts) {
        return response()->json([
            'status' => 'error',
            'message' => 'Post not found'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'post' => $posts
    ], 200);
}

public function getGst()
    {
        $gst = DB::table('apnokaca_posts')
        ->whereRaw("LOWER(category) LIKE 'gst'")
        ->orderBy('published_at', 'desc')
        ->paginate(10);

        if ($gst->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No GST gst found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'gst' => $gst->items(), 
            'pagination' => [
                'current_page' => $gst->currentPage(),
                'total_pages' => $gst->lastPage(),
                'total_items' => $gst->total(),
                'per_page' => $gst->perPage(),
            ]
        ], 200);
    }

}
