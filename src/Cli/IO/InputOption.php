<?php

    namespace Dez\Cli\IO;

    use Dez\Cli\CliException;

    /**
     * Class Option
     * @package Dez\Cli\IO
     */
    class InputOption {

        const REQUIRED  = 1;

        const OPTIONAL  = 2;

        protected $name;

        protected $short;

        protected $mode;

        protected $description;

        public function __construct( $name = null, $short = null, $mode = 0, $description = '' ) {

            if( ! $name ) {
                throw new CliException( 'Name can not be empty' );
            }

            if( $short === null ) {
                $short  = substr( ltrim( $name, '-' ), 0, 1 );
            }

            if( 0 >= $mode ) {
                $mode   = self::OPTIONAL;
            }

            $this->setName( $name )->setShort( $short )->setMode( $mode )->setDescription( $description );
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
        public function getShort() {
            return $this->short;
        }

        /**
         * @param mixed $short
         * @return static
         */
        public function setShort( $short ) {
            $this->short = $short;
            return $this;
        }

        /**
         * @return mixed
         */
        public function getMode() {
            return $this->mode;
        }

        /**
         * @param mixed $mode
         * @return static
         */
        public function setMode( $mode ) {
            $this->mode = $mode;
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
        public function setDescription( $description ) {
            $this->description = $description;
            return $this;
        }

    }