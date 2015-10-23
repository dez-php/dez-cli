<?php

    namespace Dez\Cli\IO;

    /**
     * Class Output
     * @package Dez\Cli\IO
     */
    abstract class Output {

        protected $formatter;

        public function __construct() {
            $this->setFormatter( new Formatter() );
        }

        public function writeln( $message = '' ) {
            $this->write( $message );
            return $this;
        }

        abstract protected function write( $message = '' );

        /**
         * @return Formatter
         */
        public function getFormatter() {
            return $this->formatter;
        }

        /**
         * @param mixed $formatter
         * @return Formatter
         */
        public function setFormatter( Formatter $formatter ) {
            $this->formatter = $formatter;
            return $this;
        }

    }