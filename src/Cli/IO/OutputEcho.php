<?php

    namespace Dez\Cli\IO;

    /**
     * Class OutputEcho
     * @package Dez\Cli\IO
     */
    class OutputEcho extends Output {

        /**
         * @param string $message
         * @return $this
         */
        protected function write( $message = '' ) {
            echo $this->getFormatter()->format( $message ) . PHP_EOL;
            return $this;
        }

    }