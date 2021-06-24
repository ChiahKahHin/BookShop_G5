<?php

namespace App\Http\Controllers;

use App\Models\Comment;
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
            "content" => "max:65535",
            "attachment" => ["file", "mimes:mp4,mp3,m4a,jpg,png,jpeg"]
        ]);
        $file = $request->file("attachment");
        $request->user()->comments()->create(["isbn" => $isbn, "rating" => $request->rate, "content" => $request->content, "mimeType"=> is_null($file) ? null: $file->getMimeType(), "attachment" => is_null($file) ? null: $file->get()]);
        return redirect()->route("stockDetails", ["isbn" => $isbn])->with("message", "Your comment has been added successfully");
    }

    public function editComment(Request $request, $isbn) {
        $this->validate($request, [
            "rate" => "required|in:1,2,3,4,5",
            "content" => "max:65535",
            "attachment" => ["file", "mimes:mp4,mp3,m4a,jpg,png,jpeg"]
        ]);
        $file = $request->file("attachment");
        $request->user()->comments()->where("isbn", $isbn)->update(["rating" => $request->rate, "content" => $request->content, "mimeType"=> is_null($file) ? null: $file->getMimeType(), "attachment" => is_null($file) ? null: $file->get()]);
        
        return redirect()->route("stockDetails", ["isbn" => $isbn])->with("message", "Your comment has been updated successfully");
    }
}
