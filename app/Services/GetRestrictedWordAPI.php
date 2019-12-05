<?php
/**
 * Created by PhpStorm.
 * User: Alamin
 * Date: 05-Dec-19
 * Time: 6:00 PM
 */

namespace App\Services;

use DOMDocument;

class GetRestrictedWordAPI
{
    protected $url;

    /**
     * GetRestrictedWordAPI constructor.
     */
    public function __construct()
    {
        $this->url = 'https://en.wikipedia.org/wiki/Most_common_words_in_English';
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getRestrictedWordFromWiki()
    {
        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $htmlContent = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new \Exception();
        }

        curl_close($curl);
        libxml_use_internal_errors(true);

        $dom = new domDocument;

        $dom->loadHTML($htmlContent);

        $dom->preserveWhiteSpace = false;

        $tables = $dom->getElementsByTagName('table');

        $rows = $tables->item(0)->getElementsByTagName('tr');

        $restrictWord = [];
        foreach ($rows as $key => $row) {
            if ($key != 0) {
                $cols           = $row->getElementsByTagName('td');
                $restrictWord[] = trim($cols->item(0)->nodeValue);
            }
        }

        return $restrictWord;
    }

}
