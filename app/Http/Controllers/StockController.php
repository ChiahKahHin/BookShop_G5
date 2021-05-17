<?php

namespace App\Http\Controllers;
use App\Models\Stock;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(){
        $stock = Stock::all();

        return view('dashboard', ['stock' => $stock]);
    }

    public function delete($isbn){
        $stock = Stock::findOrFail($isbn);
        $stock->delete();
        
        return redirect('/');
    }

    public function bookDetails($isbn){
        $stock = Stock::findOrFail($isbn);

        return view('stock', ['stock' => $stock]);
    }

    public function deleteStock($isbn){
        $stock = Stock::findOrFail($isbn);
        $stock->delete();

        return redirect('/');
    }

    public function homepage(){
        $stock = Stock::all();
        
        return view('home', ['stock' => $stock]);
    }

    public function homepageSearch(Request $request){
        $stock = Stock::where('book_name', 'LIKE', '%' . $request->homeSearch . '%')
        ->orWhere('book_author', 'LIKE', '%' . $request->homeSearch . '%')
        ->orWhere('book_isbn_no', 'LIKE', '%' . $request->homeSearch . '%')
        ->get();
        if($stock->isEmpty()){

            return view('noresult');
        }
        else{
            return view('homeStock', ['stock' => $stock]);
        }
    }
}
