<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Country;
use App\Models\City;
use App\Models\Author;

class TestController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get info for the form
        $author = Author::with('city.country')->find($id);
        $countries = Country::all();

        // Send the form
        return view('edit', compact('author', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        // Author update
        $author = Author::find($id);
        $author->name = $request->name;
        $author->city_id = $request->city;
        $author->save();

        // Form redirection
        return redirect(route('test.edit', $id))->with('success', 'The author was updated successfully !');
    }

    /**
     * Get country's cities.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cities($id)
    {
        // Return of cities for a selected country
        return City::whereCountryId($id)->get();
    }
}