<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // Show all listings
    public function index(){
        return view('listings.index', [
            'listings' => Listing::latest() -> filter(request(['tag', 'search'])) -> paginate(6)
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
            'description' => 'required',

        ]);

        if($request->hasFile('logo')){
            $form_fields['logo'] = $request -> file('logo')->store('logos', 'public');
        }

        // dd(auth() -> id());
        $form_fields['user_id'] = auth() -> id();
        Listing::create($form_fields);
        return redirect('/')->with('message', 'Listing created successfully.');
    }

    // Show job listing edit form
    public function edit(Listing $listing){
        
        return view('listings.edit', ['listing' => $listing]);
    }

    // Update exisiting job listing data
    public function update(Request $request, Listing $listing){

        // Make sure logged in user is the owner of the listing
        if($listing -> user_id != auth() -> id()){
            return redirect('/');
        }

        $form_fields = $request -> validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags'  => 'required',
            'description' => 'required',

        ]);

        if($request->hasFile('logo')){
            $form_fields['logo'] = $request -> file('logo')->store('logos', 'public');
        }
        $listing -> update($form_fields);
        return redirect('/listings/'.$listing->id)->with('message', 'Listing updated successfully.');
    }

    public function destroy(Listing $listing){
        if($listing -> user_id != auth() -> id()){
            return redirect('/');
        }
        $listing -> delete();
        return redirect('/') -> with('message', 'Listing deleted successfully.');
    }

    public function manage(){
        return view('listings.manage', ['listings' => auth() -> user() -> listings() -> get()]);
    }

}
