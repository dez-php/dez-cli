<?php

    namespace CliApp;

    use Dez\Cli\Cli;
    use Dez\Cli\IO\Input\Argument;
    use Dez\Cli\IO\Input\Option;
    use Dez\Cli\IO\InputArgv;

    include_once '../vendor/autoload.php';

    $console    = new Cli();

    $command = $console->setName( 'Testing...' )
        ->register( 'test-cli' )
        ->addArgument( 'id', Argument::OPTIONAL, 'Optional ID' )
        ->addOption( 'evn', 'e', Option::OPTIONAL, 'Development evn...' )
        ->setCallback( function( InputArgv $input ) {
            var_dump($input->getOption('evn'));
        } );

    $command->run();

//    print_r( $command );