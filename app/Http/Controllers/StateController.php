<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;

class StateController extends Controller
{
    private $states = array(
        "Perlis",
        "Kedah",
        "Penang",
        "Kelantan",
        "Perak",
        "Pahang",
        "Johor",
        "Terengganu",
        "Selangor",
        "Negeri Sembilan",
        "Malacca",
        "Sabah",
        "Sarawak"
    );

    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
        asort($this->states);
    }

    public function manageState()
    {
        $states = State::orderBy('state')->get();
        return view('manageState', ['states' => $states]);
    }

    public function addStateForm(){
        return view('addState', ['states' => $this->states]);
    }

    public function addState(Request $request){
        $this->validate($request, [
            'state' => 'required|unique:states,state',
            'delivery_cost' => 'required|numeric|min:0|max:50'
        ]);

        $state = new State();
        $state->state = request('state');
        $state->delivery_cost = request('delivery_cost');
        $state->save();
        return redirect('/addState')->with('message', 'State Added Successfully');
    }

    public function editStateForm($id){
        $state = State::find($id);
        return view('editState', ['states' => $this->states, 'selectedState' => $state]);
    
    }
    public function editState(Request $request, $id){
        $this->validate($request, [
            'state' => 'required|max:255|unique:states,state,'.$id.'',
            'delivery_cost' => 'required|numeric|min:0|max:50'
        ]);

        $state = State::find($id);
        $state->state = request('state');
        $state->delivery_cost = request('delivery_cost');
        $state->save();

        return redirect()->route("editState", ["id" => $id])->with("message", "State info updated successfully");
    }
}