<?php

    namespace Dez\Cli\Command;

    class CommandConfiguration {

        protected $name;

        protected $arguments    = [];

        protected $options      = [];

        /**
         * @return mixed
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param mixed $name
         * @return static
         */
        public function setName($name)
        {
            $this->name = $name;
            return $this;
        }

        /**
         * @return array
         */
        public function getArguments() {
            return $this->arguments;
        }

        /**
         * @param array $arguments
         * @return static
         */
        public function setArguments( $arguments ) {
            $this->arguments = $arguments;
            return $this;
        }

        /**
         * @return array
         */
        public function getOptions() {
            return $this->options;
        }

        /**
         * @param array $options
         * @return static
         */
        public function setOptions( $options ) {
            $this->options = $options;
            return $this;
        }

    }