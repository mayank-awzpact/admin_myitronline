<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function view_income_tax(){
        $income_tax = DB::table('apnokaca_posts')
        ->where('category', 'like', 'Income tax')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('pages.income_tax',compact('income_tax'));
    }

    

    public function privacy_policy(){
        return view('pages.privacy_policy');
    }

    public function author(){
        return view('pages.author');
    }

    public function Contact(){
        return view('pages.about');
    }

    public function view_gst(){
        $gst = DB::table('apnokaca_posts')
        ->where('category', 'like', 'Gst')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('pages.gst',compact('gst'));
    }

    public function view_finance(){
        $finance = DB::table('apnokaca_posts')
        ->where('category', 'like', 'Finance')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('pages.finance',compact('finance'));
    }
    
    public function view_rbi(){
        $rbi = DB::table('apnokaca_posts')
        ->where('category', 'like', 'RBI')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('pages.rbi',compact('rbi'));
    }

    

    public function view_budget(){
        $budget = DB::table('apnokaca_posts')
        ->where('category', 'like', 'Budget')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('pages.budget',compact('budget'));
    }

    public function view_compliance(){
        $compliance = DB::table('apnokaca_posts')
        ->where('category', 'like', 'Compliance')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('pages.compliance',compact('compliance'));
    }
    public function view_notice(){
        $notice = DB::table('apnokaca_posts')
        ->where('category', 'like', 'Notice')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('pages.notice',compact('notice'));
    }

    

    public function view_Pan_Aadhaar_News(){
        $pan = DB::table('apnokaca_posts')
        ->where('category', 'like', 'Pan & Aadhaar News')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('pages.pan',compact('pan'));
    }

    public function show_post($slug, $id)
    {

        $post = DB::table('apnokaca_posts')
            ->where('id', $id)
            ->where('slug', $slug) 
            ->first();
    
        if (!$post) {
            abort(404); 
        }
    

        $recent_posts = DB::table('apnokaca_posts')
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->select('blog_title', 'id', 'slug')
            ->limit(2)
            ->get();
    
        return view('pages.showposts', compact('post', 'recent_posts'));
    }
    
}
