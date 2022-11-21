<?php

namespace App\Http\Controllers;

use App\Models\Listing;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // Show all listings
    public function index(){
        return view('listings.index', [
            'listings' => Listing::latest() -> filter(request(['tag', 'search'])) -> get()
        ]);
    }
    
    // Show a listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // Show create form
    public function create(){
        return view('listings.create');
    }

    // Store job listing data
    public function store(Request $request){
        $form_fields = $request -> validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags'  => 'required',
            'description' => 'required'

        ]);

        Listing::create($form_fields);
        return redirect('/')->with('message', 'Listing created successfully.');
    }

}
