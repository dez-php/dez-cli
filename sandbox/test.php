<?php

    namespace CliApp;

    use Dez\Cli\Cli;
    use Dez\Cli\IO\Input;
    use Dez\Cli\IO\Input\Argument;
    use Dez\Cli\IO\Input\Option;
    use Dez\Cli\IO\Output;

    include_once '../vendor/autoload.php';

    $console    = new Cli();

    $command = $console->setName( 'Testing...' )
        ->register( 'test-cli' )
        ->addArgument( 'id', Argument::OPTIONAL, 'Optional ID' )
        ->addOption( 'evn', 'e', Option::OPTIONAL, 'Development evn...' )
        ->setCallback( function( Input $input, Output $output ) {
            $output->writeln( '{error}error test{/error}' );
            $output->writeln( '{warning}warning test{/warning}' );
            $output->writeln( '{info}info test{/info}' );
            $output->writeln( '{success}success test{/success}' );
        } );

    $command->run();

//    var_dump( $command );