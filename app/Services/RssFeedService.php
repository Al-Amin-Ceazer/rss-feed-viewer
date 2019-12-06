<?php
/**
 * Created by PhpStorm.
 * User: Alamin
 * Date: 05-Dec-19
 * Time: 6:28 PM
 */

namespace App\Services;

use App\Feed;

class RssFeedService
{
    protected $url;

    /**
     * RssFeedService constructor.
     */
    public function __construct()
    {
        $this->url = 'https://www.theregister.co.uk/software/headlines.atom';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getRssFeed()
    {
        $xml = simplexml_load_file($this->url);

        $allIFeeds = [];
        foreach ($xml->entry as $item) {
            $post            = new Feed();
            $post->id        = (string) $item->id;
            $post->updated   = date('D M Y', strtotime($item->updated));
            $post->author    = (string) $item->author->name;
            $post->authorUri = (string) $item->author->uri;
            $post->title     = (string) $item->title;
            $post->summary   = (string) trim($item->summary);
            $post->data      = $item->author->name . ' ' . $item->title . ' ' . trim($item->summary);

            $allIFeeds[] = $post;
        }

        return collect($allIFeeds);
    }

}
