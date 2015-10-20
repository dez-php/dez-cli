<?php

    namespace Dez\Cli\IO;

    /**
     * Class Input
     * @package Dez\Cli\IO
     */
    abstract class Input {

        protected $runningFile  = '';

        protected $tokens       = [];

        protected $arguments    = [];

        protected $options      = [];

        public function __construct() {
            $arguments  = $_SERVER['argv'];
            $this->setRunningFile( array_shift( $arguments ) );
            $this->setTokens( $arguments );
            $this->parse();
        }

        /**
         * @return string
         */
        public function getRunningFile()
        {
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
         * @return array
         */
        public function getTokens() {
            return $this->tokens;
        }

        /**
         * @param array $tokens
         * @return static
         */
        public function setTokens( $tokens ) {
            $this->tokens = $tokens;
            return $this;
        }

        /**
         * @return array
         */
        public function getArguments()
        {
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

        abstract protected function parse();

    }