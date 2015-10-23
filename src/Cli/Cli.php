<?php

    namespace Dez\Cli;

    use Dez\Cli\Command\Command;
    use Dez\Cli\IO\Definition;
    use Dez\Cli\IO\Input;
    use Dez\Cli\IO\Input\Argument;
    use Dez\Cli\IO\InputArgv;
    use Dez\Cli\IO\Output;
    use Dez\Cli\IO\OutputEcho;

    /**
     * Class Cli
     * @package Dez\Cli
     */
    class Cli {

        /**
         * @var array
         */
        protected $commands = [];

        /**
         * @var
         */
        protected $name;

        /**
         * @var
         */
        protected $definition;

        protected $input;

        protected $output;

        public function __construct() {
            $this->setInput( new InputArgv() )->setOutput( new OutputEcho() );
        }

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
         * @return array
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
         * @return mixed
         */
        public function getDefinition() {
            return $this->definition;
        }

        /**
         * @param mixed $definition
         * @return static
         */
        public function setDefinition( Definition $definition ) {
            $this->definition = $definition;
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

    }