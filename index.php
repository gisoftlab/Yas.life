<?php

use App\Console\CountriesConsole;

require 'vendor/autoload.php';

(new CountriesConsole($argv))->run();