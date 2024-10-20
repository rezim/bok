<?php

trait CommonTrait
{

    function getAllData($url): array
    {

        $allData = array();

        $ch = curl_init();
        $pageNb = 1;
        $perPage = 100;

        do {
            curl_setopt($ch, CURLOPT_URL, $url . '&page=' . $pageNb . '&per_page=' . $perPage);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if (USE_PROXY) {
                curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
            }
            $data = json_decode(curl_exec($ch), true);

            $allData = array_merge($allData, $data);
            $pageNb++;
        } while (count($data) == $perPage);

        curl_close($ch);

        return $allData;
    }
}