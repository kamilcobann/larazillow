<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
class RealtorListingAcceptOfferController extends Controller
{
    public function __invoke(Offer $offer)
    {
        $listing = $offer->listing;
        $this->authorize('update', $listing);
        $offer->update(['accepted_at' => now()]);

        $offer->listing->sold_at = now();
        $offer->listing->save();
        $offer->listing->offers()->except($offer)->update(['rejected_at' => now()]);

        return redirect()->back()->with('success',"Offer #{$offer->id} accepted, others rejected");
    }
}
