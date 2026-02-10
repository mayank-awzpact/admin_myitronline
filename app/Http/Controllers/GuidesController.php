<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class GuidesController extends Controller
{
    // 📌 List all guides with pagination & search
    public function index(Request $request)
    {
        $query = DB::table('guides')
            ->select('uniqueId', 'name', 'created_at')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $guides = $query->paginate(10);
        return view('guides.guides', compact('guides'));
    }

    // 📌 Show Create Guide Form
    public function create()
    {
        return view('guides.create');
    }

    // 📌 Store Guide in Database
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'horizontal_category' => 'required',
            'vertical_category' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:guides,slug',
            'guide_heading' => 'required',
            'status' => 'required',
            'description' => 'required',
            'intro_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'full_article_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'required',
            'robots' => 'required',
            'meta_keyword' => 'required',
            'tags' => 'required',
            'meta_description' => 'required',
        ]);

        try {
            // Handle Image Upload
            $intro_image_path = $request->file('intro_image')->store('public/guide');
            $full_article_image_path = $request->file('full_article_image')->store('public/guide');

            // Insert into database
            DB::table('guides')->insert([
                'uniqueId' => Crypt::encryptString(uniqid()), // Encrypt uniqueId
                'horizontal_category' => $validated_data['horizontal_category'],
                'vertical_category' => $validated_data['vertical_category'],
                'name' => $validated_data['name'],
                'slug' => $validated_data['slug'],
                'guide_heading' => $validated_data['guide_heading'],
                'status' => $validated_data['status'],
                'description' => $validated_data['description'],
                'intro_image' => str_replace('public/', '', $intro_image_path),
                'full_article_image' => str_replace('public/', '', $full_article_image_path),
                'meta_title' => $validated_data['meta_title'],
                'robots' => $validated_data['robots'],
                'meta_keyword' => $validated_data['meta_keyword'],
                'tags' => $validated_data['tags'],
                'meta_description' => $validated_data['meta_description'],
                'created_at' => now(),
            ]);

            return redirect()->route('guides.index')->with('success', 'Guide created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('guides.create')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // 📌 Show Edit Form
    public function edit($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
        } catch (\Exception $e) {
            return redirect()->route('guides.index')->with('error', 'Invalid guide ID.');
        }

        $guide = DB::table('guides')->where('uniqueId', $decryptedId)->first();

        if (!$guide) {
            return redirect()->route('guides.index')->with('error', 'Guide not found.');
        }

        return view('guides.edit', compact('guide', 'id'));
    }

    // 📌 Update Guide
    public function update(Request $request, $id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
        } catch (\Exception $e) {
            return redirect()->route('guides.index')->with('error', 'Invalid guide ID.');
        }

        $validated_data = $request->validate([
            'horizontal_category' => 'required',
            'vertical_category' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:guides,slug,' . $decryptedId . ',uniqueId',
            'guide_heading' => 'required',
            'status' => 'required',
            'description' => 'required',
            'intro_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'full_article_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'required',
            'robots' => 'required',
            'meta_keyword' => 'required',
            'tags' => 'required',
            'meta_description' => 'required',
        ]);

        $guide = DB::table('guides')->where('uniqueId', $decryptedId)->first();
        if (!$guide) {
            return redirect()->route('guides.index')->with('error', 'Guide not found.');
        }

        // Handle Image Updates
        if ($request->hasFile('intro_image')) {
            Storage::delete('public/' . $guide->intro_image);
            $intro_image_path = $request->file('intro_image')->store('public/guide');
            $validated_data['intro_image'] = str_replace('public/', '', $intro_image_path);
        } else {
            $validated_data['intro_image'] = $guide->intro_image;
        }

        if ($request->hasFile('full_article_image')) {
            Storage::delete('public/' . $guide->full_article_image);
            $full_article_image_path = $request->file('full_article_image')->store('public/guide');
            $validated_data['full_article_image'] = str_replace('public/', '', $full_article_image_path);
        } else {
            $validated_data['full_article_image'] = $guide->full_article_image;
        }

        // Update guide
        DB::table('guides')->where('uniqueId', $decryptedId)->update([
            'horizontal_category' => $validated_data['horizontal_category'],
            'vertical_category' => $validated_data['vertical_category'],
            'name' => $validated_data['name'],
            'slug' => $validated_data['slug'],
            'guide_heading' => $validated_data['guide_heading'],
            'status' => $validated_data['status'],
            'description' => $validated_data['description'],
            'intro_image' => $validated_data['intro_image'],
            'full_article_image' => $validated_data['full_article_image'],
            'meta_title' => $validated_data['meta_title'],
            'robots' => $validated_data['robots'],
            'meta_keyword' => $validated_data['meta_keyword'],
            'tags' => $validated_data['tags'],
            'meta_description' => $validated_data['meta_description'],
            'updated_at' => now(),
        ]);

        return redirect()->route('guides.index')->with('success', 'Guide updated successfully.');
    }

    // 📌 Delete Guide
    public function destroy($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
        } catch (\Exception $e) {
            return redirect()->route('guides.index')->with('error', 'Invalid guide ID.');
        }

        $guide = DB::table('guides')->where('uniqueId', $decryptedId)->first();

        if (!$guide) {
            return redirect()->route('guides.index')->with('error', 'Guide not found.');
        }

        // Delete images
        Storage::delete('public/' . $guide->intro_image);
        Storage::delete('public/' . $guide->full_article_image);

        // Delete guide
        DB::table('guides')->where('uniqueId', $decryptedId)->delete();

        return redirect()->route('guides.index')->with('success', 'Guide deleted successfully.');
    }
}
