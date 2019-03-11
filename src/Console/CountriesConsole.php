<?php

namespace App\Console;

use App\Library\Exceptions\ParameterInvalidTypeException;
use App\Library\Exceptions\ParameterMissingException;
use App\Services\CountriesService;

/**
 * Class CountriesConsole
 * @package App\Console
 */
class CountriesConsole
{

    private $params;

    /**
     * CountriesConsole constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;
    }


    private function validInputs(){

        try {
            if (count($this->params) < 2) {
                throw new ParameterMissingException('Country name');
            }

            $country = $this->params[1];
            if (!is_string($country)) {
                throw new ParameterInvalidTypeException('Country Name', gettype($country), ParameterInvalidTypeException::TYPE_STRING
                );
            }

            if (isset($this->params[2])) {
                $countryToCheck = $this->params[2];
                if (!is_string($countryToCheck)) {
                    throw new ParameterInvalidTypeException('Language Name', gettype($countryToCheck), ParameterInvalidTypeException::TYPE_STRING
                    );
                }
            }

        } catch (ParameterInvalidTypeException $e) {
            echo $e->getMessage().', status: 401'.PHP_EOL;
        } catch (ParameterMissingException $e) {
            echo $e->getMessage().', status: 400'.PHP_EOL;
        } catch (\Exception $e) {
            echo $e->getMessage().', status: 500'.PHP_EOL;
        }
    }

    public function run(){
        // input validation
         $this->validInputs();

         // RUN Service
        (new CountriesService($this->params))->getData();
    }


}
