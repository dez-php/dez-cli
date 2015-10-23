<?php

    namespace Dez\Cli\IO;

    use Dez\Cli\CliException;

    /**
     * Class Argument
     * @package Dez\Cli\IO
     */
    class InputArgument {

        const REQUIRED  = 1;

        const OPTIONAL  = 2;

        protected $name;

        protected $mode;

        protected $description;

        protected $position = 0;

        public function __construct( $name = null, $mode = 0, $description = '' ) {

            if( ! $name ) {
                throw new CliException( 'Name can not be empty' );
            }

            if( 0 >= $mode ) {
                $mode   = self::OPTIONAL;
            }

            $this->setName( $name )->setMode( $mode )->setDescription( $description );
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

        /**
         * @return int
         */
        public function getPosition() {
            return $this->position;
        }

        /**
         * @param int $position
         * @return static
         */
        public function setPosition( $position ) {
            $this->position = $position;
            return $this;
        }

    }