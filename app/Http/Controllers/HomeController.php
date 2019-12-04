<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $url = 'https://www.theregister.co.uk/software/headlines.atom';
        $xml = @simplexml_load_file($url);

        $allItem = [];
        foreach ($xml->entry as $item) {
            $post          = new Item();
            $post->id      = (string) $item->id;
            $post->updated = strtotime($item->updated);
            $post->author  = (string) $item->author->name;
            $post->title   = (string) $item->title;
            $post->summary = (string) $item->summary;

            $allItem[] = $post;
        }
        //dd(collect($allItem));

        $posts = collect($allItem);

        return view('home', compact('posts'));
    }
}
