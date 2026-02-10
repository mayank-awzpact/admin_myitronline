<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class ServicesController extends Controller
{

  public function index(Request $request)
{
    $query = DB::table('tbl_service_v2')
        ->select('uniqueId', 'serviceName', 'serviceHeading', 'createdOn')
        ->orderBy('createdOn', 'desc');

    if ($request->has('search') && !empty($request->search)) {
        $query->where(function ($q) use ($request) {
            $q->where('serviceName', 'like', '%' . $request->search . '%')
              ->orWhere('serviceHeading', 'like', '%' . $request->search . '%');
        });
    }

    $services = $query->paginate(10);

    return view('service.services', compact('services'));
}


    public function create()
    {
        return view('service.create');
    }

    // public function store(Request $request)
    // {
    //     $validated_data = $request->validate([
    //         'serviceName' => 'required',
    //         'serviceAlias' => 'required',
    //         'serviceHeading' => 'required',
    //         'serviceSynopsis' => 'nullable',
    //         'serviceDescription' => 'required',
    //         'servicePrice' => 'required|numeric|min:0',
    //         'priceDiscount' => 'nullable|numeric|min:0',
    //         'gst' => 'nullable|numeric|between:0,100',
    //         'status' => 'required',
    //         'Offer_date' => 'nullable|string',
    //         'metaTitle' => 'required',
    //         'metaKeyword' => 'required',
    //         'metaDescription' => 'required',
    //         'tag' => 'required',
    //     ]);


    //     $faqTitles = $request->input('faq_titles', []);
    //     $faqContents = $request->input('faq_contents', []);

    //     $faqTitlesString = implode('```', array_map('trim', $faqTitles));
    //     $faqContentsString = implode('```', array_map('trim', $faqContents));


    //     DB::table('tbl_service_v2')->insert([
    //         'serviceName' => $request->input('serviceName'),
    //         'serviceAlias' => $request->input('serviceAlias'),
    //         'serviceHeading' => $request->input('serviceHeading'),
    //         'serviceSynopsis' => $request->input('serviceSynopsis'),
    //         'serviceDescription' => $request->input('serviceDescription'),
    //         'servicePrice' => $request->input('servicePrice'),
    //         'priceDiscount' => $request->input('priceDiscount'),
    //         'gst' => $request->input('gst'),
    //         'Offer_date' => $request->input('Offer_date'),
    //         'metaTitle' => $request->input('metaTitle'),
    //         'metaKeyword' => $request->input('metaKeyword'),
    //         'metaDescription' => $request->input('metaDescription'),
    //         'tag' => $request->input('tag'),
    //         'serFaqTitle' => $faqTitlesString,
    //         'serFaqContent' => $faqContentsString,
    //         'createdOn' => time(),
    //     ]);


    //     return redirect()->route('services.index')->with('success', 'Service created successfully.');
    // }


    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'serviceName' => 'required',
            'serviceAlias' => 'required',
            'serviceHeading' => 'required',
            'serviceSynopsis' => 'nullable',
            'serviceDescription' => 'required',
            'servicePrice' => 'required|numeric|min:0',
            'priceDiscount' => 'nullable|numeric|min:0',
            'gst' => 'nullable|numeric|between:0,100',
            'status' => 'required',
            'Offer_date' => 'nullable|string',
            'metaTitle' => 'required',
            'metaKeyword' => 'required',
            'metaDescription' => 'required',
            'tag' => 'required',
            'secTitle' => 'nullable|string',
            'secSTitle' => 'nullable|string',
            'secDescrption' => 'nullable|string',
        ]);

        $faqTitles = $request->input('faq_titles', []);
        $faqContents = $request->input('faq_contents', []);

        $faqTitlesString = implode('```', array_map('trim', $faqTitles));
        $faqContentsString = implode('```', array_map('trim', $faqContents));

        $secTitles = $request->input('secTitle', []);
        $secSTitles = $request->input('secSTitle', []);
        $secDescriptions = $request->input('secDescrption', []);

        $secTitlesString = implode('```', array_map('trim', $secTitles));
        $secSTitlesString = implode('```', array_map('trim', $secSTitles));
        $secDescriptionsString = implode('```', array_map('trim', $secDescriptions));

        DB::table('tbl_service_v2')->insert([
            'serviceName' => $request->input('serviceName'),
            'serviceAlias' => $request->input('serviceAlias'),
            'serviceHeading' => $request->input('serviceHeading'),
            'serviceSynopsis' => $request->input('serviceSynopsis'),
            'serviceDescription' => $request->input('serviceDescription'),
            'servicePrice' => $request->input('servicePrice'),
            'priceDiscount' => $request->input('priceDiscount'),
            'gst' => $request->input('gst'),
            'Offer_date' => $request->input('Offer_date'),
            'metaTitle' => $request->input('metaTitle'),
            'metaKeyword' => $request->input('metaKeyword'),
            'metaDescription' => $request->input('metaDescription'),
            'tag' => $request->input('tag'),
            'serFaqTitle' => $faqTitlesString,
            'serFaqContent' => $faqContentsString,
            'secTitle' => $secTitlesString,
            'secSTitle' => $secSTitlesString,
            'secDescrption' => $secDescriptionsString,
            'createdOn' => time(),
        ]);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }




    public function edit($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
        } catch (\Exception $e) {
            return redirect()->route('services.index')->with('error', 'Invalid service ID.');
        }

        $service = DB::table('tbl_service_v2')->where('uniqueId', $decryptedId)->first();

        if (!$service) {
            return redirect()->route('services.index')->with('error', 'Service not found.');
        }

        return view('service.edit', compact('service', 'id'));
    }

    // public function update(Request $request, $id)
    // {
    //     try {
    //         $decryptedId = Crypt::decryptString($id);
    //     } catch (\Exception $e) {
    //         return redirect()->route('services.index')->with('error', 'Invalid service ID.');
    //     }

    //     $faqTitles = $request->input('faq_titles', []);
    //     $faqContents = $request->input('faq_contents', []);

    //     $faqTitlesString = implode('```', array_map('trim', $faqTitles));
    //     $faqContentsString = implode('```', array_map('trim', $faqContents));

    //     DB::table('tbl_service_v2')
    //         ->where('uniqueId', $decryptedId)
    //         ->update([
    //             'serviceName' => $request->serviceName,
    //             'serviceAlias' => $request->serviceAlias,
    //             'serviceHeading' => $request->serviceHeading,
    //             'serviceSynopsis' => $request->serviceSynopsis,
    //             'serviceDescription' => $request->serviceDescription,
    //             'servicePrice' => $request->servicePrice,
    //             'priceDiscount' => $request->priceDiscount,
    //             'gst' => $request->gst,
    //             'Offer_date' => $request->Offer_date,
    //             'metaTitle' => $request->metaTitle,
    //             'metaKeyword' => $request->metaKeyword,
    //             'metaDescription' => $request->metaDescription,
    //             'tag' => $request->tag,
    //             'serFaqTitle' => $faqTitlesString,
    //             'serFaqContent' => $faqContentsString,
    //             'updatedOn' => time(),
    //         ]);

    //     return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    // }


public function update(Request $request, $id)
{
    try {
        $decryptedId = Crypt::decryptString($id);
    } catch (\Exception $e) {
        return redirect()->route('services.index')->with('error', 'Invalid service ID.');
    }
    $DELIM = '```';
    $trimJoin = function (array $items) use ($DELIM): string {
        $arr = array_map(static fn($v) => is_string($v) ? trim($v) : '', $items);
        while (!empty($arr) && $arr[0] === '') { array_shift($arr); }
        while (!empty($arr) && end($arr) === '') { array_pop($arr); }
        return implode($DELIM, $arr);
    };

    $faqTitlesString   = $trimJoin($request->input('faq_titles', []));
    $faqContentsString = $trimJoin($request->input('faq_contents', []));


    $secTitleCombined  = $request->input('secTitle');
    $secSTitleCombined = $request->input('secSTitle');
    $secDescCombined   = $request->input('secDescrption');

    if ($secTitleCombined === null) {
        $secTitleCombined = $trimJoin($request->input('secTitle_rows', []));
    }
    if ($secSTitleCombined === null) {
        $secSTitleCombined = $trimJoin($request->input('secSTitle_rows', []));
    }
    if ($secDescCombined === null) {
        $secDescCombined = $trimJoin($request->input('secDescrption_rows', []));
    }

    DB::table('tbl_service_v2')
        ->where('uniqueId', $decryptedId)
        ->update([
            'serviceName'        => $request->input('serviceName'),
            'serviceAlias'       => $request->input('serviceAlias'),
            'serviceHeading'     => $request->input('serviceHeading'),
            'serviceSynopsis'    => $request->input('serviceSynopsis'),
            'serviceDescription' => $request->input('serviceDescription'), // if you’re using it
            'servicePrice'       => $request->input('servicePrice'),
            'priceDiscount'      => $request->input('priceDiscount'),
            'gst'                => $request->input('gst'),
            'Offer_date'         => $request->input('Offer_date'),
            'status'             => $request->input('status'),


            'secTitle'           => $secTitleCombined,
            'secSTitle'          => $secSTitleCombined,
            'secDescrption'      => $secDescCombined,

            'serFaqTitle'        => $faqTitlesString,
            'serFaqContent'      => $faqContentsString,

            'metaTitle'          => $request->input('metaTitle'),
            'metaKeyword'        => $request->input('metaKeyword'),
            'metaDescription'    => $request->input('metaDescription'),
            'tag'                => $request->input('tag'),

            'updatedOn'          => time(),
        ]);

    return redirect()->route('services.index')->with('success', 'Service updated successfully.');
}




    public function destroy($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid service ID.'], 400);
        }

        DB::table('tbl_service_v2')->where('uniqueId', $decryptedId)->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

 public function servicemeta(Request $request)
{
    $query = DB::table('myitr_meta_seo')
        ->join('tbl_service_v2', 'myitr_meta_seo.service_id', '=', 'tbl_service_v2.uniqueId')
        ->select('myitr_meta_seo.*', 'tbl_service_v2.serviceName','tbl_service_v2.serviceHeading');

    if ($request->has('search') && !empty($request->search)) {
        $query->where('tbl_service_v2.serviceName', 'like', '%' . $request->search . '%');
    }

    $meta = $query->orderBy('myitr_meta_seo.created_at', 'desc')->paginate(10);

    return view('service.meta', compact('meta'));
}




    public function meta_create(){
        $meta = DB::table('tbl_service_v2')
           ->select('*')->get();
        return view('service.meta_create', compact('meta'));

    }

    public function meta_store(Request $request)
{
    $request->validate([
        'serviceName'     => 'required|integer',
        'domain'          => 'required|integer|in:1,2,3,4',
        'metaTitle'       => 'required|string|max:255',
        'metaKeyword'     => 'required|string|max:255',
        'metaDescription' => 'required|string',
        'tag'             => 'required|string',
    ]);
    DB::table('myitr_meta_seo')->insert([
        'service_id'      => $request->serviceName,
        'domain_id'       => $request->domain,
        'metaTitle'       => $request->metaTitle,
        'metaKeyword'     => $request->metaKeyword,
        'metaDescription' => $request->metaDescription,
        'tag'             => $request->tag,
        'created_at'      => now(),
        'updated_at'      => now(),
    ]);
        return redirect()->route('services.servicemeta')->with('success', 'Meta saved successfully.');
}

public function meta_edit($id)
{
    $meta = DB::table('myitr_meta_seo')->where('id', $id)->first();

    if (!$meta) {
        return redirect()->route('services.servicemeta')->with('error', 'Meta not found.');
    }

    $services = DB::table('tbl_service_v2')->select('uniqueId', 'serviceName','serviceHeading')->get();
// dd($services);
    return view('service.meta_edit', compact('meta', 'services'));
}

public function meta_update(Request $request, $id)
{
    $request->validate([
        'service_id'      => 'required|integer',
        'domain_id'       => 'required|integer|in:1,2,3,4',
        'metaTitle'       => 'required|string|max:255',
        'metaKeyword'     => 'required|string|max:255',
        'metaDescription' => 'required|string',
        'tag'             => 'required|string',
    ]);

    DB::table('myitr_meta_seo')->where('id', $id)->update([
        'service_id'      => $request->service_id,
        'domain_id'       => $request->domain_id,
        'metaTitle'       => $request->metaTitle,
        'metaKeyword'     => $request->metaKeyword,
        'metaDescription' => $request->metaDescription,
        'tag'             => $request->tag,
        'updated_at'      => now(),
    ]);

    return redirect()->route('services.servicemeta')->with('success', 'Meta updated successfully.');
}

public function meta_delete($id)
{
    DB::table('myitr_meta_seo')->where('id', $id)->delete();
    return redirect()->route('services.servicemeta')->with('error', 'Meta Delete successfully.');

}


}
