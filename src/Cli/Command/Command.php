<?php

    namespace Dez\Cli\Command;

    use Dez\Cli\CliException;
    use Dez\Cli\IO\Definition;
    use Dez\Cli\IO\Input\Argument;
    use Dez\Cli\IO\Input\Option;
    use Dez\Cli\IO\InputArgv;

    class Command {

        protected $name;

        protected $description;

        protected $callback;

        protected $definition;

        public function __construct( $name ) {
            $this->setName( $name );
            $this->setDefinition( new Definition() );
            $this->configure();
        }

        public function configure() {

        }

        public function execute() {
            throw new CliException( 'Calling execute() can be from extended command' );
        }

        public function run() {

            $input          = new InputArgv();

            $definition     = $this->getDefinition();

            foreach( $definition->getArguments() as $i => $argument ) {
                if( ! $input->hasArgument( $i ) && $argument->getMode() & Argument::REQUIRED ) {
                    throw new CliException( sprintf( 'Required argument "%s" not found', $argument->getName() ) );
                }
            }

            foreach( $definition->getOptions() as $option ) {
                if( ! $input->hasOption( $option ) && $option->getMode() & Argument::REQUIRED ) {
                    throw new CliException( sprintf( 'Required option "%s" not found', $option->getName() ) );
                }
            }

            $callback   = $this->getCallback();

            if( ! $callback ) {
                $this->execute();
            } else {
                call_user_func_array( $callback, [ $input ] );
            }

            return $this;

        }

        public function addOption( $name, $short = null, $mode = 0, $description = '' ) {
            $this->getDefinition()->addOption( new Option( $name, $short, $mode, $description ) );
            return $this;
        }

        public function addArgument( $name, $mode = 0, $description = '' ) {
            $this->getDefinition()->addArgument( new Argument( $name, $mode, $description ) );
            return $this;
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
         * @return mixed
         */
        public function getCallback() {
            return $this->callback;
        }

        /**
         * @param mixed $callback
         * @return static
         */
        public function setCallback( $callback ) {
            $this->callback = $callback;
            return $this;
        }

        /**
         * @return Definition
         */
        public function getDefinition() {
            return $this->definition;
        }

        /**
         * @param Definition $definition
         * @return static
         */
        public function setDefinition( Definition $definition ) {
            $this->definition = $definition;
            return $this;
        }

    }