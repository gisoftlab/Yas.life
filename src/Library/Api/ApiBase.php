<?php

namespace App\Library\Api;

/**
 * Class ApiBase
 * @package App\Library\Api
 */
class ApiBase {

    /**
     * makeAgent
     * @param bool $default
     * @return bool|string
     */
    public function makeAgent($default = false){
        if(!$default)
            return  (isset($_SERVER['HTTP_USER_AGENT']) ? urlencode($_SERVER['HTTP_USER_AGENT']) : urlencode('Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5'));
        {
            return $default;
        }
    }
    
    /**
     * getResponse
     *
     * @param $requestUrl
     * @param null $postString
     * @return bool|mixed
     */
    public function getResponse($requestUrl, $postString = null) {
        $vtime = time();

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $requestUrl);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_COOKIEFILE, "/tmp/google_". $vtime . ".txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, "/tmp/google_". $vtime . ".txt");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); //1
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //1
        curl_setopt($curl, CURLOPT_USERAGENT, $this->makeAgent());

        if (strlen($postString) > 0) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postString);
        }

        $response = curl_exec($curl);
        curl_close($curl);

        if(!$response){
            return false;
        }

        return json_decode($response,true);
    }
}