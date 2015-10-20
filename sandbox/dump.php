<?php

    namespace CliApp;

    use Dez\Cli\IO\InputArgv;

    include_once '../vendor/autoload.php';

    $input    = new InputArgv();

    print_r( $input );