<?php

    namespace Dez\Cli\Command;

    use Dez\Cli\Cli;
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

        protected $application;

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

            try {
                $this->runCommand();
            } catch ( \Exception $exception ) {
                $this->renderException( $exception );
            }

            return $this;
        }

        protected function runCommand() {

            $this->initialize();

            $input  = $this->getApplication()->getInput();

            $definition     = $this->getDefinition();

            foreach( $definition->getArguments() as $i => $argument ) {
                if( ! $input->hasArgument( $i ) && $argument->getMode() & Argument::REQUIRED ) {
                    throw new CliException( sprintf( 'Required argument "%s" not found', $argument->getName() ) );
                }
            }

            foreach( $definition->getOptions() as $option ) {
                if( ! $input->hasOption( $option->getName() ) && $option->getMode() & Argument::REQUIRED ) {
                    throw new CliException( sprintf( 'Required option "%s" not found', $option->getName() ) );
                }
            }

            $callback   = $this->getCallback();

            if( ! $callback ) {
                $this->execute();
            } else if( $callback instanceof \Closure ) {
                call_user_func_array( $callback, [
                    $this->getApplication()->getInput(),
                    $this->getApplication()->getOutput()
                ] );
            } else {
                throw new CliException( 'Bad callback function. Set only callback function of Closure instance' );
            }

            return $this;

        }

        protected function renderException( \Exception $exception ) {

            $output     = $this->getApplication()->getOutput();
            $traces     = [];
            $error      = [ '', ];

            $title      = sprintf( '  [%s]  ', get_class( $exception ) );
            $maxLength  = strlen( $title );
            $error[]    = $title;
            $error[]    = '';

            foreach( explode( "\n", $exception->getMessage() ) as $line ) {
                $line       = sprintf( '  %s  ', $line );
                $maxLength  = max( strlen( $line ), $maxLength );
                $error[]    = $line;
            }

            $error[]    = '';

            foreach( $error as & $errorLine ) {
                $errorLine  = str_pad( $errorLine, $maxLength, ' ', STR_PAD_RIGHT );
                $errorLine  = sprintf( '{error}%s{/error}', $errorLine );
            }

            foreach( $exception->getTrace() as $trace ) {

                $class      = isset( $trace['class'] ) ? $trace['class'] : '';
                $type       = isset( $trace['type'] ) ? $trace['type'] : '';

                $function   = $trace['function'];

                $file       = isset( $trace['file'] ) ? $trace['file'] : 'null';
                $line       = isset( $trace['line'] ) ? $trace['line'] : 'null';

                $traces[] = sprintf(
                    '   %s @ %s',
                    "{style:blue,black} {$class}{$type}{$function}() {/style}",
                    "{style:green,black,underscore,bold}{$file}:{$line}{/style}"
                );
            }

            $output->writeln()
                ->writeln( implode( "\n", $error ) )
                ->writeln()->writeln()
                ->writeln( implode( "\n", $traces ) )->writeln();

            return $this;
        }

        protected function initialize() {

            $application    = $this->getApplication();

            if( ! $application || ! ( $application instanceof Cli ) ) {
                throw new CliException( 'Application instance require for command' );
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

        /**
         * @return Cli
         */
        public function getApplication() {
            return $this->application;
        }

        /**
         * @param Cli $application
         * @return static
         */
        public function setApplication( Cli $application ) {
            $this->application = $application;
            return $this;
        }

    }