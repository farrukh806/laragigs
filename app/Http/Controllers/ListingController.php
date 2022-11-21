<?php

namespace App\Http\Controllers;

use App\Models\Listing;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\List_;

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
        Listing::create($form_fields);
        return redirect('/')->with('message', 'Listing created successfully.');
    }

    // Show job listing edit form
    public function edit(Listing $listing){
        
        return view('listings.edit', ['listing' => $listing]);
    }

    // Update exisiting job listing data
    public function update(Request $request, Listing $listing){

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
        $listing -> delete();
        return redirect('/') -> with('message', 'Listing deleted successfully.');
    }

}
