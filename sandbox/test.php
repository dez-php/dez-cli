<?php

    namespace CliApp;

    use Dez\Cli\Cli;
    use Dez\Cli\IO\Colorizer;
    use Dez\Cli\IO\Input;
    use Dez\Cli\IO\Input\Argument;
    use Dez\Cli\IO\Input\Option;
    use Dez\Cli\IO\Output;

    include_once '../vendor/autoload.php';

    $console    = new Cli();

    $command = $console->setName( 'Testing...' )
        ->register( 'test-cli' );

    $command->addArgument( 'id', Argument::OPTIONAL, 'Optional ID' )
        ->addOption( 'evn', 'e', Option::OPTIONAL, 'Development evn...' )
        ->setCallback( function( Input $input, Output $output ) use ( $command ) {

            $output->getFormatter()->setColorizer(
                'crazy', new Colorizer( 'yellow', 'magenta', [ 'bold', 'underscore' ] )
            );

            $output->writeln( '[error]test error[/error]' );
            $output->writeln( '[error fg="yellow" extra="underscore"]modify error tag[/error]' );
            $output->writeln( '[warning]warning test[/warning]' );
            $output->writeln( '[info]info test[/info]' );
            $output->writeln( '[success]success test[/success]' );

            $output->writeln( '[crazy]crazy test !!!111[/crazy]' );

            throw new \BadFunctionCallException( 'Some error' );

        } );

    $command->run();

//    var_dump( $command );