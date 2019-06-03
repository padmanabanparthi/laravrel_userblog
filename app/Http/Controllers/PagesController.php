<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct()
    {
    }

    public function index(){
        $data['pageId'] = 1;
        $data['posts'] = Post::latest()->limit(3)->get();
        //return $data['posts'];
        return view("index",$data);
    }

    public function notes(){
        $data['pageId'] = 2;
        return view('notes',$data);
    }
    
}
