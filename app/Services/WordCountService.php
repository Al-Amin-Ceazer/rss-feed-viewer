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
        $this->url       = 'https://en.wikipedia.org/wiki/Most_common_words_in_English';
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
            $words = $this->cleanString($value->data);
            foreach ($words as $word) {
                $word          = preg_replace("#[^a-zA-Z-]#", "", $word);
                $counts[$word] += 1;
            }
        }

        // remove unwanted array element
        unset($counts[""]);
        // sort the array
        arsort($counts);

        //get excluded top 50 English common words
        $restrictWords = $this->wordCount->getRestrictedWordFromWiki();

        foreach ($counts as $key => $value) {
            if (in_array($key, $restrictWords)) {
                unset($counts[$key]);
            }
        }

        $topTenWord = array_splice($counts,0,10);

        return $topTenWord;
    }

    /**
     * @param $str
     *
     * @return array
     */
    protected function cleanString($str)
    {
        $str     = strtolower(strip_tags($str));
        $str     = trim(preg_replace('/[\t\n\r\s]+/', ' ', $str));
        $str     = str_replace('"', "", $str);
        $wordArr = explode(' ', $str);

        return $wordArr;
    }
}
