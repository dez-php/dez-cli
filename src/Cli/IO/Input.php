<?php

    namespace Dez\Cli\IO;

    /**
     * Class Input
     * @package Dez\Cli\IO
     */
    abstract class Input {

        protected $runningFile      = '';

        protected $command          = '';

        protected $arguments        = [];

        protected $options          = [];

        static protected $tokens    = [];

        public function __construct() {
            $arguments  = $_SERVER['argv'];
            $this->setRunningFile( array_shift( $arguments ) );

            if( isset( $arguments[0] ) ) {
                $this->setCommand( array_shift( $arguments ) );
            }

            $this->setTokens( $arguments );
            $this->parse();
        }

        /**
         * @return string
         */
        public function getRunningFile() {
            return $this->runningFile;
        }

        /**
         * @param string $runningFile
         * @return static
         */
        public function setRunningFile( $runningFile ) {
            $this->runningFile = $runningFile;
            return $this;
        }

        /**
         * @return string
         */
        public function getCommand() {
            return $this->command;
        }

        /**
         * @param string $command
         * @return static
         */
        public function setCommand( $command ) {
            $this->command = $command;
            return $this;
        }

        /**
         * @return array
         */
        public function getTokens() {
            return static::$tokens;
        }

        /**
         * @param array $tokens
         * @return static
         */
        public function setTokens( $tokens ) {
            static::$tokens = $tokens;
            return $this;
        }

        /**
         * @return array
         */
        public function getOptions() {
            return $this->options;
        }

        /**
         * @param $name
         * @param $value
         * @return static
         */
        public function setOption( $name, $value ) {
            $this->options[$name] = ! $value ? true : $value;
            return $this;
        }

        /**
         * @param $name
         * @return bool
         */
        public function hasOption( $name ) {
            return isset( $this->options[ $name ] );
        }

        /**
         * @param $name
         * @param null $default
         * @return array|null
         */
        public function getOption( $name, $default = null ) {
            return $this->hasOption( $name ) ? $this->options[$name] : $default;
        }

        /**
         * @return array
         */
        public function getArguments() {
            return $this->arguments;
        }

        /**
         * @param $name
         * @param $argument
         * @return static
         */
        public function setArgument( $name, $argument ) {
            $this->arguments[$name] = $argument;
            return $this;
        }

        /**
         * @param $name
         * @param null $default
         * @return array|null
         */
        public function getArgument( $name, $default = null ) {
            $arguments  = is_int( $name ) ? array_values( $this->arguments ) : $this->arguments;
            return $this->hasArgument( $name ) ? $arguments[ $name ] : $default;
        }

        /**
         * @param $name
         * @return bool
         */
        public function hasArgument( $name ) {
            $arguments  = is_int( $name ) ? array_values( $this->arguments ) : $this->arguments;
            return isset( $arguments[ $name ] );
        }

        /**
         * @return mixed
         */
        abstract protected function parse();

    }