<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditHouse;
use App\Http\Requests\NewHouse;
use App\Models\House;
use App\Models\User;
use Illuminate\Http\Request;

class HousesController extends Controller
{
    //

    public function showHousesPage() {
        return view('houses');
    }

    public function createHouse(NewHouse $request) {
        $attributes = $request->validated();

        $house = House::create($attributes);

        return redirect()->back()->with('status', "Namas $house->address sėkmingai sukurtas");
    }

    public function editHouse(EditHouse $request, $id) {
        $house = House::findOrFail($id);
        $attributes = $request->validated();

        $house->update($attributes);

        return redirect()->back()->with('status', "Namas $house->address sėkmingai atnaujintas");
    }

    public function deleteHouse($id) {
        $house = House::findOrFail($id);

        $house->delete();

        return redirect()->back()->with('status', "Namas $house->address sėkmingai ištrintas");
    }
}
