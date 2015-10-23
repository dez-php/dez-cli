<?php

    namespace Dez\Cli;

    use Dez\Cli\Command\Command;
    use Dez\Cli\IO\Input;
    use Dez\Cli\IO\InputArgv;
    use Dez\Cli\IO\Output;
    use Dez\Cli\IO\OutputStream;

    /**
     * Class Cli
     * @package Dez\Cli
     */
    class Cli {

        const VERSION   = '1.0.0';

        const PACKAGE   = 'CLI Component';

        const URL       = 'https://github.com/dez-php/dez-cli';


        /**
         * @var array
         */
        protected $commands = [];

        /**
         * @var string
         */
        protected $name;

        /**
         * @var Input
         */
        protected $input;

        /**
         * @var Output
         */
        protected $output;

        /**
         *
         */
        public function __construct() {
            $this->setInput( new InputArgv() )->setOutput( new OutputStream() );
            $this->registerDefaultCommands();
        }

        /**
         * @return $this
         */
        public function execute() {
            if( $this->has( $this->getInput()->getCommand() ) ) {
                $this->get( $this->getInput()->getCommand() )->run();
            } else {
                $this->notFoundCommand();
            }

            return $this;
        }

        /**
         * @param $name
         * @return Command
         */
        public function register( $name ) {
            $command    = new Command( $name );
            $this->add( $command->setApplication( $this ) );
            return $command;
        }

        /**
         * @param $command
         */
        public function add( Command $command ) {
            $this->commands[ $command->getName() ]  = $command;
        }

        /**
         * @param $name
         * @return bool
         */
        public function has( $name ) {
            return isset( $this->commands[ $name ] );
        }

        /**
         * @param $name
         * @return null|Command
         */
        public function get( $name ) {
            return $this->has( $name ) ? $this->commands[ $name ] : null;
        }

        /**
         * @return Command[]
         */
        public function getCommands() {
            return $this->commands;
        }

        /**
         * @param array $commands
         * @return static
         */
        public function setCommands($commands) {

            foreach( $commands as $command ) {
                $this->add( $command );
            }

            return $this;
        }

        /**
         * @return mixed
         */
        public function getName() {
            return $this->name;
        }

        /**
         * @param mixed $name
         * @return static
         */
        public function setName( $name ) {
            $this->name = $name;
            return $this;
        }

        /**
         * @return Input
         */
        public function getInput() {
            return $this->input;
        }

        /**
         * @param Input $input
         * @return static
         */
        public function setInput( Input $input ) {
            $this->input = $input;
            return $this;
        }

        /**
         * @return Output
         */
        public function getOutput() {
            return $this->output;
        }

        /**
         * @param Output $output
         * @return static
         */
        public function setOutput( Output $output ) {
            $this->output = $output;
            return $this;
        }

        /**
         * @return $this
         */
        protected function notFoundCommand() {
            $output     = $this->getOutput();

            $output->writeln()->writeln( sprintf(
                '[error]  %s  [/error]', "Command not '{$this->getInput()->getCommand()}' not found"
            ) )->writeln();

            $this->allCommands();

            return $this;
        }

        protected function allCommands() {
            $output     = $this->getOutput();

            $output->writeln( str_repeat( '-', 50 ) );
            $output->writeln()->writeln( '[info]Registered commands[/info]' )->writeln();

            foreach( $this->getCommands() as $command ) {
                $commandInfo    = '[success]  - %s [/success](%s)';
                $output->writeln( sprintf( $commandInfo, $command->getName(), $command->getDescription() ) );
            }

            $output->writeln();
            $output->writeln( str_repeat( '-', 50 ) )->writeln();

            return $this;
        }

        /**
         * @return $this
         */
        protected function registerDefaultCommands() {

            $command    = $this->register( 'about' );

            $command->setCallback( function( Input $input, Output $output ) {
                $output->writeln()->writeln( str_repeat( '-', 50 ) );
                $output->writeln()->writeln( '[info]'. Cli::PACKAGE .'[/info]' );
                $output->writeln( '[info]Version: '. Cli::VERSION .'[/info]' );
                $output->writeln( 'URL: [style extra="underscore,bold"]'. Cli::URL .'[/style]' )->writeln();
                $this->allCommands();
            } );

            return $this;
        }

    }