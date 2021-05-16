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

    public function destroy($isbn){
        $stock = Stock::findOrFail($isbn);
        $stock->delete();
        
        return redirect('/');
    }

    public function show($isbn){
        $stock = Stock::findOrFail($isbn);

        return view('stock', ['stock' => $stock]);
    }

    public function deleteStock($isbn){
        $stock = Stock::findOrFail($isbn);
        $stock->delete();

        return redirect('/');
    }
}
