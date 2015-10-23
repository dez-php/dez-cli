<?php

    namespace Dez\Cli\Command;

    use Dez\Cli\Cli;
    use Dez\Cli\CliException;
    use Dez\Cli\IO\Input;
    use Dez\Cli\IO\InputArgument;
    use Dez\Cli\IO\InputOption;
    use Dez\Cli\IO\Output;

    class Command {

        protected $name;

        protected $description;

        protected $callback;

        protected $application;

        protected $configuration;

        public function __construct( $name = null, array $configuration = [] ) {
            $this->setConfiguration( new CommandConfiguration(
                $configuration
            ) )->getConfiguration()->setName( $name );
            $this->setName( $name );
            $this->configure();
        }

        /**
         *
         */
        public function configure() {

        }

        /**
         * @throws CliException
         */
        public function execute( Input $input, Output $output ) {
            throw new CliException( 'Calling execute() can be from extended command' );
        }

        /**
         * @return $this
         */
        public function run() {

            try {
                $this->runCommand();
            } catch ( \Exception $exception ) {
                $this->renderException( $exception );
            }

            return $this;
        }

        /**
         * @return $this
         * @throws CliException
         */
        protected function runCommand() {

            $this->initialize();

            $input              = $this->getApplication()->getInput();
            $output             = $this->getApplication()->getOutput();

            $configuration      = $this->getConfiguration();

            foreach( $configuration->getArguments() as $name => $argument ) {
                if(
                    $argument->getMode() & InputArgument::REQUIRED &&
                    ! $input->hasArgument( $argument->getPosition() )
                ) {
                    throw new CliException( sprintf( 'Required argument "%s" not found', $argument->getName() ) );
                }
            }

            foreach( $configuration->getOptions() as $option ) {
                if(
                    $option->getMode() & InputOption::REQUIRED && (
                        ! $input->hasOption( $option->getName() ) &&
                        ! $input->hasOption( $option->getShort() )
                    )
                ) {
                    throw new CliException( sprintf( 'Required option "%s" not found', $option->getName() ) );
                }
            }

            $callback   = $this->getCallback();

            if( ! $callback ) {
                $this->execute( $input, $output );
            } else if( $callback instanceof \Closure ) {
                call_user_func_array( $callback, [ $input, $output ] );
            } else {
                throw new CliException( 'Bad callback function. Set only callback function of Closure instance' );
            }

            return $this;

        }

        /**
         * @param \Exception $exception
         * @return $this
         */
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
                $errorLine  = sprintf( '  [error]%s[/error]', $errorLine );
            }

            foreach( $exception->getTrace() as $trace ) {

                $class      = isset( $trace['class'] ) ? $trace['class'] : '';
                $type       = isset( $trace['type'] ) ? $trace['type'] : '';

                $function   = $trace['function'];

                $file       = isset( $trace['file'] ) ? $trace['file'] : 'null';
                $line       = isset( $trace['line'] ) ? $trace['line'] : 'null';

                $traces[] = sprintf(
                    '  [style fg="blue" extra="bold"]%s [/style] @ [style fg="green" extra="underscore,bold"]%s[/style]',
                    "{$class}{$type}{$function}()",
                    "{$file}:{$line}"
                );
            }

            $output->writeln()
                ->writeln( implode( "\n", $error ) )
                ->writeln()->writeln()
                ->writeln( implode( "\n", $traces ) )->writeln();

            return $this;
        }

        /**
         * @return $this
         * @throws CliException
         */
        protected function initialize() {

            $application    = $this->getApplication();

            if( ! $application || ! ( $application instanceof Cli ) ) {
                throw new CliException( 'Application instance require for command' );
            }

            return $this;
        }

        /**
         * @param $name
         * @param null $short
         * @param int $mode
         * @param string $description
         * @return $this
         */
        public function addOption( $name, $short = null, $mode = 0, $description = '' ) {
            $this->getConfiguration()->addOption( new InputOption( $name, $short, $mode, $description ) );
            return $this;
        }

        /**
         * @param $name
         * @param int $mode
         * @param string $description
         * @return $this
         */
        public function addArgument( $name, $mode = 0, $description = '' ) {
            $this->getConfiguration()->addArgument( new InputArgument( $name, $mode, $description ) );
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

        /**
         * @return CommandConfiguration
         */
        public function getConfiguration() {
            return $this->configuration;
        }

        /**
         * @param CommandConfiguration $configuration
         * @return static
         */
        public function setConfiguration( CommandConfiguration $configuration ) {
            $this->configuration = $configuration;
            return $this;
        }

    }