<?php

    namespace Dez\Cli\IO;


    /**
     * Class OutputStream
     * @package Dez\Cli\IO
     */
    class OutputStream extends Output {

        /**
         * @param string $message
         * @return $this
         */
        protected function write( $message = '' ) {
            $stream     = fopen( 'php://stdout', 'w' );
            fwrite( $stream, $this->getFormatter()->format( $message ) . PHP_EOL );
            fclose( $stream );
            return $this;
        }

    }