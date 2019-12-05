<?php

namespace App\Http\Controllers;

use App\Services\RssFeedService;
use App\Services\WordCountService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $wordCount;
    protected $rssFeed;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\WordCountService $wordCount
     * @param \App\Services\RssFeedService   $rssFeed
     */
    public function __construct(WordCountService $wordCount, RssFeedService $rssFeed)
    {
        $this->middleware('auth');
        $this->wordCount = $wordCount;
        $this->rssFeed   = $rssFeed;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        $feeds = $this->rssFeed->getRssFeed();

        $wordCountResult = $this->wordCount->getMostCountedWord($feeds);

        return view('home', compact('feeds', 'wordCountResult'));
    }
}
