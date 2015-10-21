<?php

    namespace Dez\Cli;

    use Dez\Cli\Command\Command;
    use Dez\Cli\IO\Definition;
    use Dez\Cli\IO\Input\Argument;

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

        public function __construct() {

            $this->setDefinition( new Definition( [
                new Argument( 'command', Argument::REQUIRED, 'Command to execute' )
            ] ) );

        }

        public function register( $name ) {
            $command    = new Command( $name );
            $this->add( $command );
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



    }