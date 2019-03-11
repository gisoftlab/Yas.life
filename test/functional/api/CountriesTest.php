<?php
namespace App\Test\Functional\Api;

require('vendor/autoload.php');

use App\Console\CountriesConsole;
use PHPUnit\Framework\TestCase;


/**
 * Class CountriesTest
 * @package App\Test\Functiona\Api
 *
 * RUN TEST
 * composer test test/functional/api/CountriesTest.php
 * ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/functional/api/CountriesTest.php
 *
 */
class CountriesTest extends TestCase
{
    private $testData = [
        "index.php",
        "Spain",
    ];

    private $testData2 = [
        "index.php",
        "Spain",
        "Argentina",
    ];

    private $testData3 = [
        "index.php",
        "Spain",
        "Poland",
    ];

    private $testDataMissing = [
        "index.php",
    ];

    private $testDataInvalidInput = [
        "index.php",
        "Spain1",
    ];

    private $testDataInvalidInput2 = [
        "index.php",
        "Spain",
        "Argentina2",
    ];

    private $testDataInvalidInput3 = [
        "index.php",
        1,
    ];

    public function testGetCountriesByISOs()
    {
        (new CountriesConsole($this->testData))->run();

        $this->assertTrue(strpos($this->getActualOutput(),"Country language code") !== false);
        echo PHP_EOL."testGetCountriesByISOs ok";
    }

    public function testParameterMissing()
    {
        (new CountriesConsole($this->testDataMissing))->run();

        $this->assertTrue(strpos($this->getActualOutput(),"status: 400") !== false);
        echo PHP_EOL."testParameterMissing ok";
    }

    public function testParameterInvalid()
    {
       (new CountriesConsole($this->testDataInvalidInput))->run();

        $this->assertTrue(strpos($this->getActualOutput(),"status: 402") !== false);
        echo PHP_EOL."testParameterInvalid ok";
    }

    public function testParameterInvalid3()
    {
        (new CountriesConsole($this->testDataInvalidInput3))->run();

        $this->assertTrue(strpos($this->getActualOutput(),"status: 401") !== false);
        echo PHP_EOL."testParameterInvalid ok";
    }

    public function testCheckLangIsInCountriesOK()
    {
        (new CountriesConsole($this->testData2))->run();

        $this->assertTrue(strpos($this->getActualOutput(),"speak the same language") !== false);
        echo PHP_EOL."testCheckLangIsInCountriesOK ok";
    }

    public function testCheckLangIsInCountriesNO()
    {
        (new CountriesConsole($this->testData3))->run();

        $this->assertTrue(strpos($this->getActualOutput(),"do not speak the same language") !== false);
        echo PHP_EOL."testCheckLangIsInCountriesNO ok";
    }

    public function testParameterInvalid2()
    {
        (new CountriesConsole($this->testDataInvalidInput2))->run();

        $this->assertTrue(strpos($this->getActualOutput(),"status: 402") !== false);
        echo PHP_EOL."testParameterInvalid2 ok";
    }
}