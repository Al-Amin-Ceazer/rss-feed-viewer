<?php
/**
 * Created by PhpStorm.
 * User: Alamin
 * Date: 05-Dec-19
 * Time: 6:09 PM
 */

namespace App\Services;

class WordCountService
{
    protected $wordCount;

    /**
     * WordCountService constructor.
     *
     * @param \App\Services\GetRestrictedWordAPI $wordCount
     */
    public function __construct(GetRestrictedWordAPI $wordCount)
    {
        $this->url = 'https://en.wikipedia.org/wiki/Most_common_words_in_English';
        $this->wordCount = $wordCount;
    }

    /**
     * @param $dataArray
     *
     * @return array
     * @throws \Exception
     */
    public function getMostCountedWord($dataArray)
    {
        error_reporting(error_reporting() & ~E_NOTICE);
        $counts = [];
        foreach ($dataArray as $value) {
            // clean the string
            $word  = trim(preg_replace('/[\t\n\r\s]+/', ' ', strtolower(strip_tags($value->summary))));
            $word  = str_replace('"', "", $word);
            $words = explode(' ', str_replace('.', "", $word));

            foreach ($words as $word) {

                if (!empty($word)) {
                    $word          = preg_replace("#[^a-zA-Z-]#", "", $word);
                    $counts[$word] += 1;
                }
            }
        }

        // remove unwanted array element
        unset($counts[""]);
        // remove duplicate array elements
        $counts = array_unique($counts);
        // sort the array
        arsort($counts);

        //get excluding top 50 English common words
        $restrictWords = $this->wordCount->getRestrictedWordFromWiki();

        foreach ($counts as $key => $value) {
            if (in_array($key, $restrictWords)) {
                unset($counts[$key]);
            }
        }

        return $counts;
    }
}
