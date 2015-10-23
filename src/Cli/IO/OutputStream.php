<?php

    namespace Dez\Cli\IO;


    /**
     * Class OutputStream
     * @package Dez\Cli\IO
     */

    class OutputStream extends Output {

        /**
         * @var resource
         */
        protected $stream;


        public function __construct() {
            parent::__construct();
            $this->setStream( fopen( 'php://stdout', 'w' ) );
        }

        public function __destruct() {
            @ fclose( $this->getStream() );
        }

        /**
         * @param string $message
         * @return $this
         */
        protected function write( $message = '' ) {
            fwrite( $this->getStream(), $this->getFormatter()->format( $message ) . PHP_EOL );
            return $this;
        }

        /**
         * @return mixed
         */
        public function getStream() {
            return $this->stream;
        }

        /**
         * @param mixed $stream
         * @return static
         */
        public function setStream( $stream ) {
            $this->stream = $stream;
            return $this;
        }

    }