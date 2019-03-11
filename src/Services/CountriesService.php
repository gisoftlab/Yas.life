<?php

namespace App\Services;

use App\Library\Api\ApiBase;
use App\Library\Api\ApiLoaderInterface;
use App\Library\Exceptions\ParameterMissingException;
use App\Library\Exceptions\ResponseInvalidException;
use App\Library\Exceptions\ResponseNotFoundException;

/**
 * Class CountriesService
 * @package App\Services
 */
class CountriesService extends ApiBase implements ApiLoaderInterface
{

    /**
     * @var string $urlApi
     */
    const urlApi = "https://restcountries.eu/rest/v2/";

    /**
     * @var string $urlApiSearchByLang
     */
    const urlApiSearchByLang = self::urlApi.'lang/{et}';

    /**
     * @var string $urlApiSearchByLang
     */
    const urlApiSearchByName = self::urlApi.'name/{name}?fullText=true';

    /**
     * @var string $country
     */
    private $country;

    /**
     * @var string $countryCheck
     */
    private $countryToCheck;

    /**
     * @var array $params
     */
    private $params;

    /**
     * CountriesService constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;
        if(isset($this->params[1])) {
            $this->country = $this->params[1];
        }
        if(isset($this->params[2])) {
            $this->countryToCheck = $this->params[2];
        }
    }

    /**
     * getAllCountryLanguages
     *
     * @param string $country
     * @return array
     * @throws ResponseInvalidException
     * @throws ResponseNotFoundException
     */
    private function getAllCountryLanguages($country)
    {
        $urlApiSearchByName = str_replace('{name}', $country, self::urlApiSearchByName);

        $response = $this->getResponse($urlApiSearchByName);

        if (!isset($response[0])) {
            throw new ResponseNotFoundException($country);
        }

        $repos = $response[0];

        if (!isset($repos['languages'])) {
            throw new ResponseInvalidException($response, 'languages');
        }

        return $repos['languages'];
    }

    /**
     * getISOs
     *
     * @return array
     * @throws ResponseInvalidException
     * @throws ResponseNotFoundException
     */
    private function getISOs()
    {
       $languages = $this->getAllCountryLanguages($this->country);

        $isos = [];
        foreach ($languages as $index => $language) {
            if (!isset($language['iso639_1'])) {
                throw new ResponseInvalidException($language, 'iso639_1');
            }

            $isos[] = $language['iso639_1'];
        }

        return $isos;
    }

    /**
     * getCountriesByISO
     *
     * @param $iso
     * @return string
     * @throws ParameterMissingException
     * @throws ResponseInvalidException
     * @throws ResponseNotFoundException
     */
    private function getCountriesByISO($iso)
    {

        if (!$iso) {
            throw new ParameterMissingException('ISO name');
        }

        $urlApiSearchByISO = str_replace('{et}', $iso, self::urlApiSearchByLang);

        $response = $this->getResponse($urlApiSearchByISO);

        if (!isset($response[0])) {
            throw new ResponseNotFoundException($iso);
        }

        $names = "";

        foreach ($response as $index => $country) {

            if (!isset($country['name'])) {
                throw new ResponseInvalidException($response, 'name');
            }

            if ($index != 0) {
                $names .= ", ";
            }

            $names .= $country['name'];

        }

        return $names;
    }

    /**
     * checkSpeekTheSameLanguage
     *
     * @param $country
     * @return array
     * @throws ResponseInvalidException
     * @throws ResponseNotFoundException
     */
    private function getLangsByCountry($country)
    {
        $languages = $this->getAllCountryLanguages($country);

        $names = [];
        foreach ($languages as $index => $language) {

            if (!isset($language['name'])) {
                throw new ResponseInvalidException($language, 'name');
            }

            $names [$language['name']] = $language['name'];
        }

        return $names;
    }

    /**
     * checkSpeakTheSameLanguage
     *
     * @throws ResponseInvalidException
     * @throws ResponseNotFoundException
     */
    private function checkSpeakTheSameLanguage()
    {
        $countryLangs = $this->getLangsByCountry($this->country);
        $countryToCheckLangs = $this->getLangsByCountry($this->countryToCheck);

        $checkCountryLang = " do not";
        foreach ($countryLangs as $index => $language) {
            if(isset($countryToCheckLangs[$language])){
                $checkCountryLang = "";
            }
        }

        echo $this->country.' and '.$this->countryToCheck.$checkCountryLang.' speak the same language'.PHP_EOL;
    }

    /**
     * checkCountryData
     *
     * @throws ParameterMissingException
     * @throws ResponseInvalidException
     * @throws ResponseNotFoundException
     */
    private function printCountryData(){
        $isos = $this->getISOs();

        foreach ($isos as $index => $iso) {
            $countries = $this->getCountriesByISO($iso);

            echo 'Country language code: '.$iso.PHP_EOL;
            echo $this->country,' speaks same language with these countries: '.$countries.PHP_EOL;
        }
    }

    /**
     * getData
     * @return mixed|void
     */
    public function getData()
    {
        try {
            if(count($this->params) == 2){
                $this->printCountryData();
            }

            if(count($this->params) == 3){
                $this->checkSpeakTheSameLanguage();
            }

        } catch (ResponseInvalidException $e) {
            echo $e->getMessage().', status: 403'.PHP_EOL;
        } catch (ResponseNotFoundException $e) {
            echo $e->getMessage().', status: 402'.PHP_EOL;
        } catch (ParameterMissingException $e) {
            echo $e->getMessage().', status: 400'.PHP_EOL;
        } catch (\Exception $e) {
            echo $e->getMessage().', status: 500'.PHP_EOL;
        }
    }
}
