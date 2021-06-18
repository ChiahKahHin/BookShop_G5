<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function addComment(Request $request, $isbn) {
        $this->validate($request, [
            "rate" => "required|in:1,2,3,4,5",
            "content" => "required|max:65535",
            "attachment" => "image"
        ]);

        $request->user()->comments()->create(["isbn" => $isbn, "rating" => $request->rate, "content" => $request->content, "attachment" => $request->attachment]);
        return redirect()->route("stockDetails", ["isbn" => $isbn]);
    }
}
