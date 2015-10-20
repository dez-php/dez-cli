<?php

    namespace Dez\Cli;

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
        protected $description;

        /**
         * @var
         */
        protected $definition;

        public function register( $name ) {
            $this->add( $name );
        }

        /**
         * @param $command
         */
        public function add( $command ) {

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
        public function getDescription() {
            return $this->description;
        }

        /**
         * @param mixed $description
         * @return static
         */
        public function setDescription( $description )  {
            $this->description = $description;
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
        public function setDefinition( $definition ) {
            $this->definition = $definition;
            return $this;
        }



    }