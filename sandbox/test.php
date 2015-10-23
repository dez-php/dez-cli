<?php

    namespace CliApp;

    use Dez\Cli\Cli;
    use Dez\Cli\Command\CommandConfiguration;
    use Dez\Cli\IO\Colorizer;
    use Dez\Cli\IO\Input;
    use Dez\Cli\IO\InputArgument;
    use Dez\Cli\IO\InputOption;
    use Dez\Cli\IO\Output;

    include_once '../vendor/autoload.php';

    $console    = new Cli();

    $console
        ->register( 'test' )
        ->setDescription( 'Testing cli component' )
        ->setConfiguration( new CommandConfiguration( [
            new InputArgument( 'user_id', InputArgument::REQUIRED ),
            new InputArgument( 'event_id', InputArgument::REQUIRED ),
            new InputArgument( 'post_id', InputArgument::REQUIRED )
        ] ) )
        ->addOption( 'evn', 'e', InputOption::REQUIRED )
        ->setCallback(function( Input $input, Output $output ){
            $output->writeln( sprintf( '[error]%s[/error]', $input->getOption( 'e', 'none' ) ) );
            $output->writeln( sprintf( '[info]%s[/info]', $input->getArgument( 0 ) . ' ' . $input->getArgument( 1 ) . ' ' . $input->getArgument( 2 ) ) );
        });

    $console
        ->register( 'colors' )
        ->setDescription( 'Printing on terminal some text' )
        ->addArgument( 'id', InputArgument::OPTIONAL, 'Optional ID' )
        ->addOption( 'evn', 'e', InputOption::OPTIONAL, 'Development evn...' )
        ->setCallback( function( Input $input, Output $output ) {

            $output->getFormatter()->setColorizer(
                'crazy', new Colorizer( 'yellow', 'magenta', [ 'bold', 'underscore' ] )
            );

            $output->writeln( '[error]test error[/error]' );
            $output->writeln( '[error fg="yellow" extra="underscore"]modify error tag[/error]' );
            $output->writeln( '[warning]warning test[/warning]' );
            $output->writeln( '[info]info test[/info]' );
            $output->writeln( '[success]success test[/success]' );
            $output->writeln( '[crazy]crazy test !!!111[/crazy]' );
            $output->writeln( sprintf( '[style fg="cyan"]all arguments (%s)[/style]', implode( ',', $input->getArguments() ) ) );
            $output->writeln( sprintf( '[style bg="blue" fg="white"]all options (%s)[/style]', implode( ',', $input->getOptions() ) ) );
        } );

    $console->execute();