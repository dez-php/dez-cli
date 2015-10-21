<?php

    namespace Dez\Cli\IO;

    use Dez\Cli\CliException;
    use Dez\Cli\IO\Input\Argument;
    use Dez\Cli\IO\Input\Option;

    /**
     * Class Definition
     * @package Dez\Cli\IO
     */
    class Definition {

        protected $arguments    = [];

        protected $options      = [];

        /**
         * @param array $definitions
         * @throws CliException
         */
        public function __construct( array $definitions = [] ) {

            if( count( $definitions ) > 0 ) {
                foreach( $definitions as $definition ){
                    if( $definition instanceof Option ) {
                        $this->addOption( $definition );
                    } else if( $definition instanceof Argument ) {
                        $this->addArgument( $definition );
                    } else {
                        throw new CliException( 'Bad definition pass in constructor' );
                    }
                }
            }

        }

        /**
         * @param Argument $argument
         */
        public function addArgument( Argument $argument ) {
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
         * @param Option $option
         */
        public function addOption( Option $option ) {
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
         * @return Argument[]
         */
        public function getArguments() {
            return $this->arguments;
        }

        /**
         * @return Option[]
         */
        public function getOptions() {
            return $this->options;
        }

    }