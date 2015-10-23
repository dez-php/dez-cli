<?php

    namespace Dez\Cli\IO;

    use Dez\Cli\CliException;

    class FormatterStyler {

        static protected $foregroundColors = [
            'black'     => 30,
            'red'       => 31,
            'green'     => 32,
            'yellow'    => 33,
            'blue'      => 34,
            'magenta'   => 35,
            'cyan'      => 36,
            'white'     => 37,
            'default'   => 39,
        ];

        static protected $backgroundColors = array(
            'black'     => 40,
            'red'       => 41,
            'green'     => 42,
            'yellow'    => 43,
            'blue'      => 44,
            'magenta'   => 45,
            'cyan'      => 46,
            'white'     => 47,
            'default'   => 49,
        );

        static protected $options = array(
            'bold'          => [ 'set' => 1, 'reset' => 22 ],
            'underscore'    => [ 'set' => 4, 'reset' => 24 ],
            'blink'         => [ 'set' => 5, 'reset' => 25 ],
            'reverse'       => [ 'set' => 7, 'reset' => 27 ],
            'conceal'       => [ 'set' => 8, 'reset' => 28 ],
        );

        protected $foregroundColor;

        protected $backgroundColor;

        protected $option;

        public function __construct( $foregroundColor = null, $backgroundColor = null, array $options = [] ) {
            if( $foregroundColor ) {
                $this->setForegroundColor( $foregroundColor );
            }

            if( $backgroundColor ) {
                $this->setBackgroundColor( $backgroundColor );
            }

            if( $options ) {
                $this->setOptions( $options );
            }
        }

        public function colorize( $message = '' ) {

            $styles = [];
            $reset  = [];

            if( $this->getForegroundColor() ) {
                $styles[]   = $this->getForegroundColor();
                $reset[]    = static::$foregroundColors['default'];
            }

            if( $this->getBackgroundColor() ) {
                $styles[]   = $this->getBackgroundColor();
                $reset[]    = static::$backgroundColors['default'];
            }

            if( $this->getOption() ) {
                foreach( $this->getOption() as $option ) {
                    $styles[]   = $option['set'];
                    $reset[]    = $option['reset'];
                }
            }

            return sprintf( "\x1B[%sm{$message}\x1B[%sm", implode( ';', $styles ), implode( ';', $reset ) );
        }

        /**
         * @return mixed
         */
        public function getBackgroundColor() {
            return $this->backgroundColor;
        }

        /**
         * @param mixed $backgroundColor
         * @return static
         * @throws CliException
         */
        public function setBackgroundColor( $backgroundColor ) {

            if( ! isset( static::$backgroundColors[ $backgroundColor ] ) ) {
                throw new CliException( sprintf(
                    'Background color "%s" not found, use only (%s)',
                    $backgroundColor, implode( ', ', array_keys( static::$backgroundColors ) )
                ) );
            }

            $this->backgroundColor = static::$backgroundColors[ $backgroundColor ];
            return $this;
        }

        /**
         * @return mixed
         */
        public function getForegroundColor() {
            return $this->foregroundColor;
        }

        /**
         * @param mixed $foregroundColor
         * @return static
         * @throws CliException
         */
        public function setForegroundColor( $foregroundColor ) {

            if( ! isset( static::$foregroundColors[ $foregroundColor ] ) ) {
                throw new CliException( sprintf(
                    'Foreground color "%s" not found, use only (%s)',
                    $foregroundColor, implode( ', ', array_keys( static::$foregroundColors ) )
                ) );
            }

            $this->foregroundColor = static::$foregroundColors[ $foregroundColor ];
            return $this;
        }

        /**
         * @return mixed
         */
        public function getOption() {
            return $this->option;
        }

        /**
         * @param mixed $option
         * @return static
         */
        public function setOptions( array $option = [] ) {
            foreach( $option as $optionItem ) {
                $this->setOption( $optionItem );
            }
            return $this;
        }

        /**
         * @param mixed $option
         * @return static
         * @throws CliException
         */
        public function setOption( $option ) {

            if( ! isset( static::$options[ $option ] ) ) {
                throw new CliException( sprintf(
                    'Option "%s" not found, use only (%s)',
                    $option, implode( ', ', array_keys( static::$options ) )
                ) );
            }

            $this->option[] = static::$options[ $option ];
            return $this;
        }

    }