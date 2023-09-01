<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ListingController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Listing::class,'listing');
    }


    // public function __construct()
    // {
    //     $this->middleware('auth')->except(['index','show'])
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $filters =  $request->only([
            'priceFrom','priceTo','beds','baths','areaFrom','areaTo'
        ]);

        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,
                'listings' => Listing::mostRecent()
                ->filters($filters)
                ->withoutSold()
                ->paginate(10)
                ->withQueryString()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        // if(Auth::user()->cannot('view',$listing)){
        //     abort(403);
        // }

        // $this->authorize('view', $listing);

        $listing->load(['images']);
        $offer = !Auth::user() ? null : $listing->offers()->byMe()->first();
        return inertia(
            'Listing/Show',
            [
                'listing' => $listing,
                'offerMade' => $offer
            ]
        );
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

}