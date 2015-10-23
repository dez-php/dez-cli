<?php

    namespace Dez\Cli\Command;

    use Dez\Cli\CliException;
    use Dez\Cli\IO\InputArgument;
    use Dez\Cli\IO\InputOption;

    class CommandConfiguration {

        protected $name;

        protected $arguments    = [];

        protected $options      = [];

        public function __construct( array $configuration = [] ) {
            if( count( $configuration ) > 0 ) {
                foreach( $configuration as $item ){
                    if( $item instanceof InputOption ) {
                        $this->addOption( $item );
                    } else if( $item instanceof InputArgument ) {
                        $this->addArgument( $item );
                    } else {
                        throw new CliException( 'Bad definition pass in constructor' );
                    }
                }
            }
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
         * @param InputOption $option
         */
        public function addOption( InputOption $option ) {
            $this->options[ $option->getName() ]    = $option;
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
         * @return bool
         */
        public function getOption( $name ) {
            return $this->hasArgument( $name ) ? $this->options[ $name ] : false;
        }

        /**
         * @param InputArgument $argument
         */
        public function addArgument( InputArgument $argument ) {
            $argument->setPosition( count( $this->arguments ) );
            $this->arguments[ $argument->getName() ]    = $argument;
        }

        /**
         * @param $name
         * @return bool
         */
        public function hasArgument( $name ) {
            return isset( $this->arguments[ $name ] );
        }

        /**
         * @param $name
         * @return bool
         */
        public function getArgument( $name ) {
            return $this->hasArgument( $name ) ? $this->arguments[ $name ] : false;
        }

        /**
         * @return InputArgument[]
         */
        public function getArguments() {
            return $this->arguments;
        }

        /**
         * @return InputOption[]
         */
        public function getOptions() {
            return $this->options;
        }

    }