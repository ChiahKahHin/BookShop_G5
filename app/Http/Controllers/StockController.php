<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function addStockForm(){
        return view('addStock');
    }

    public function store(Request $request){
        $this->validate($request, [
            'book_name' => 'required|max:255',
            'book_author' => 'required|max:255',
            'book_publication_date' => 'required',
            'book_isbn_no' => 'required|regex:/(?=(?:[0-9]+[-●]){4})[-●0-9]{17}$/|min:17|max:17',//123-1-12-123456-0
            'book_description' => 'required|max:65535',
            'book_front_cover' => 'required',
            'book_trade_price_input' => 'required|numeric|min:0|max:500',
            'book_retail_price_input' => 'required|numeric|min:0|max:500',
            'book_quantity_input' => 'required|numeric|min:1|max:20'
        ]);
        
        $stock = Stock::find(request('book_isbn_no'));
        if($stock == null){
            $stock = new Stock();
            $message = "Book Added Successfully";
        }
        else{
            $message = "Book Updated Successfully";
        }
        $stock->book_name = request('book_name');
        $stock->book_author = request('book_author');
        $stock->book_publication_date = request('book_publication_date');
        $stock->book_isbn_no = request('book_isbn_no');
        $stock->book_description = request('book_description');
        $stock->book_front_cover = file_get_contents(request('book_front_cover'));
        $stock->book_trade_price = request('book_trade_price_input');
        $stock->book_retail_price = request('book_retail_price_input');
        $stock->book_quantity = request('book_quantity_input');
        $stock->save();

        return redirect('/addStock')->with('message', $message);
    }

    public function editStockForm($isbn) {
        $stock = Stock::findOrFail($isbn);
        return view("editStock", ["stock" => $stock]);
    }

    public function editStock(Request $request, $isbn) {
        $this->validate($request, [
            'book_name' => 'required|max:255',
            'book_author' => 'required|max:255',
            'book_publication_date' => 'required',
            'book_description' => 'required|max:65535',
            'book_trade_price_input' => 'required|numeric|min:0|max:500',
            'book_retail_price_input' => 'required|numeric|min:0|max:500',
            'book_quantity_input' => 'required|numeric|min:1|max:20'
        ]);
        
        $stock = Stock::findOrFail($isbn);
        $stock->book_name = request('book_name');
        $stock->book_author = request('book_author');
        $stock->book_publication_date = request('book_publication_date');
        $stock->book_description = request('book_description');
        if (request('book_front_cover'))
            $stock->book_front_cover = file_get_contents(request('book_front_cover'));
        $stock->book_trade_price = request('book_trade_price_input');
        $stock->book_retail_price = request('book_retail_price_input');
        $stock->book_quantity = request('book_quantity_input');
        $stock = Stock::findOrFail($isbn);
        return redirect()->route("editStock", ["isbn" => $isbn])->with("message", "Stock updated successfully");
    }
}
