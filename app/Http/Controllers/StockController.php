<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->except(["homepage", "homepageSearch", "bookDetails"]);
        $this->middleware(['admin'])->only(["addStockForm", "store", "editStockForm", "editStock", "index", "delete", "deleteStock", "checkISBN"]);
        $this->middleware(['customer'])->only(["addToCart", "showCart", "deleteCartItem"]);
    }

    public function addStockForm()
    {
        return view('addStock');
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'book_name' => 'required|max:255',
                'book_author' => 'required|max:255',
                'book_publication_date' => 'required',
                'book_isbn_no' => 'required|regex:/^(?=(?:\d+-){4})\d{3}-[-\d]{13}$/|min:17|max:17', //123-1-12-123456-0
                'book_description' => 'required|max:65535',
                'book_front_cover' => 'required|file',
                'book_trade_price_input' => 'required|numeric|min:0|max:500',
                'book_retail_price_input' => 'required|numeric|gte:' . request('book_trade_price_input') . '|min:0|max:500',
                'book_quantity_input' => 'required|numeric|min:1|max:20'
            ],
            [
                'book_retail_price_input.gte' => 'The book retail price must be greater or equal to book trade price'
            ]
        );

        $stock = Stock::find(request('book_isbn_no'));
        if ($stock == null) {
            $stock = new Stock();
            $message = "Book Added Successfully";
        } else {
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

    public function editStockForm($isbn)
    {
        $stock = Stock::findOrFail($isbn);
        return view("editStock", ["stock" => $stock]);
    }

    public function editStock(Request $request, $isbn)
    {
        $this->validate(
            $request,
            [
                'book_name' => 'required|max:255',
                'book_author' => 'required|max:255',
                'book_publication_date' => 'required',
                'book_description' => 'required|max:65535',
                'book_front_cover' => 'file',
                'book_trade_price_input' => 'required|numeric|min:0|max:500',
                'book_retail_price_input' => 'required|numeric|gte:' . request('book_trade_price_input') . '|min:0|max:500',
                'book_quantity_input' => 'required|numeric|min:1|max:20'
            ],
            [
                'book_retail_price_input.gte' => 'The book retail price must be greater or equal to book trade price'
            ]
        );

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
        $stock->save();
        return redirect()->route("editStock", ["isbn" => $isbn])->with("message", "Stock updated successfully");
    }

    public function index()
    {
        $stock = Stock::all();

        return view('dashboard', ['stock' => $stock]);
    }

    public function delete($isbn)
    {
        $stock = Stock::findOrFail($isbn);
        $stock->delete();

        return redirect('/dashboard');
    }

    public function bookDetails($isbn)
    {
        $stock = Stock::findOrFail($isbn);

        return view('stock', ['stock' => $stock]);
    }

    public function deleteStock($isbn)
    {
        $stock = Stock::findOrFail($isbn);
        $stock->delete();

        return redirect('/dashboard');
    }

    public function homepage()
    {
        $stock = Stock::all();

        return view('home', ['stock' => $stock]);
    }

    public function homepageSearch(Request $request)
    {
        $stock = Stock::where('book_name', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('book_author', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('book_isbn_no', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->get();
        if ($stock->isEmpty()) {
            return view('noresult');
        } else {
            return view('homeStock', ['stock' => $stock]);
        }
    }

    public function checkISBN(Request $request){
        $stock = Stock::find($request->isbn);
        
        if($stock == null)
            return false; // unique ISBN
        else
            return true; // duplicated ISBN
    }

    public function addToCart(Request $request)
    {
        $userID = request('userID');
        $searchInfo = ['user_id' => $userID, 'book_isbn_no' => request('stockISBN')];
        
        $stock = Cart::where($searchInfo)->first();

        if ($stock === null) {
            $cart = new Cart();
            $cart->user_id = $userID;
            $cart->book_isbn_no = request('stockISBN');
            $cart->book_quantity = request('stockQty');
            $cart->save();
            return "success";
        } else {
            $checkStock = Stock::where('book_isbn_no', request('stockISBN'))->first();

            if($stock->book_quantity != $checkStock->book_quantity){
                if(($stock->book_quantity + request('stockQty')) == $checkStock->book_quantity){
                    $stock->book_quantity += request('stockQty');
                    $stock->save();
                    return "success";
                }
                else if(($stock->book_quantity + request('stockQty')) > $checkStock->book_quantity){
                    $difference = $checkStock->book_quantity - $stock->book_quantity;
                    $stock->book_quantity = $checkStock->book_quantity;
                    $stock->save();
                    return $difference;
                }
                else{
                    $stock->book_quantity += request('stockQty');
                    $stock->save();
                    return "success";
                }
            }
            else{
                return "sameAmount";
            }
        }
    }

    public function showCart()
    {
        $stock = array();
        $userID = Auth::id();

        $cart = Cart::where('user_id', $userID)->get()->toJson();
        // $cart2 = $cart->toJson();

        $stockItem = Stock::all();

        foreach(json_decode($cart) as $c){
            $result = Stock::where('book_isbn_no', $c->book_isbn_no)->get();
            foreach($result as $r){
                if($r->book_quantity == 0){ //current solution to having a book that has 0 quantity stock is to delete the book from the cart
                    $delete = Cart::where('user_id', $userID)->where('book_isbn_no', $c->book_isbn_no)->first();
                    $delete->delete();
                }
                else{
                    if($c->book_quantity > $r->book_quantity){
                        $updateCartQty = Cart::where('book_isbn_no', $c->book_isbn_no)->first();
                        $updateCartQty->book_quantity = $r->book_quantity;
                        $updateCartQty->save();
    
                        $stock1 = [
                            'cart_id' => $c->id,
                            'book_isbn_no' => $c->book_isbn_no,
                            'book_name' => $r->book_name,
                            'book_author' => $r->book_author,
                            'book_quantity' => $r->book_quantity,
                            'book_retail_price' => $r->book_retail_price,
                            'book_front_cover' => base64_encode($r->book_front_cover)
                        ];
                        array_push($stock, $stock1);              
                    }
                    else{
                        $stock1 = [
                            'cart_id' => $c->id,
                            'book_isbn_no' => $c->book_isbn_no,
                            'book_name' => $r->book_name,
                            'book_author' => $r->book_author,
                            'book_quantity' => $c->book_quantity,
                            'book_retail_price' => $r->book_retail_price,
                            'book_front_cover' => base64_encode($r->book_front_cover)
                        ];
                        array_push($stock, $stock1);
                    }
                }
            }
            // array_push($stock, $stock1);
        }
        $stock = json_encode($stock);

        return view('cart', ['cart' => $stock], ['stock' => $stockItem]);
    }

    public function deleteCartItem($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        $cart = Cart::all();
        return redirect('/cart');
    }

    public function updateCartItemNumber(Request $request)
    {
        $cart = Cart::find($request->cartId);
        $cart->book_quantity = $request->bookQty;
        $cart->save();
    }

    // public function showCart()
    // {
    //     $stock = array();
    //     $userID = Auth::id();

    //     $cart = Cart::where('user_id', $userID)->get();
    //     $cart2 = $cart->toJson();
    //     //$test = count($cart);
    //     $val = 0;
    //     foreach(json_decode($cart2) as $cart2){
    //         $book = Stock::where('book_isbn_no', $cart2->book_isbn_no)->get();
    //         foreach($book as $book){
    //             $stock1 = [
    //                 'book_isbn_no' => $cart2->book_isbn_no,
    //                 'book_name' => $book->book_name,
    //                 'book_author' => $book->book_author,
    //                 'book_front_cover' => $book->book_front_cover,
    //                 'book_quantity' => $cart2->book_quantity,
    //                 'book_retail_price' => $book->book_retail_price
    //             ];
    //             $val += $book->book_retail_price;
    //         }
            
    //         array_push($stock, $stock1);
    //     }
    //     $stock = json_encode($stock);
    //     //$result = Stock::where('book_isbn_no', $cart[0]->book_isbn_no)->get();
    //     // $test2 = $cart[0]->book_isbn_no;
    //     $test2 = $val;

    //     return view('cart', ['cart' => $cart, 'stock' => $stock]);

    //     // return view('cart', ['cart' => $cart, 'result' => $result, 'test' => $test, 'test2' => $test2, 'cart2' => $cart2, 'stock' => $stock]);
    // }
}
