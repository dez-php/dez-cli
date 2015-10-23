<?php

    namespace Dez\Cli\IO;

    use Dez\Cli\CliException;

    /**
     * Class Formatter
     * @package Dez\Cli\IO
     */
    class Formatter {

        /**
         * @var array
         */
        protected $styles   = [];

        /**
         * @var string
         */
        static protected $placeholderRegexp    = '~\{([\w:,?]+)\}(.+)\{\/\w+\}~Uuis';

        /**
         * Constructor
         */
        public function __construct() {
            $this->setStyles( [
                'info'      => new FormatterStyler( 'green', false, [ 'bold' ] ),
                'success'   => new FormatterStyler( 'cyan', false, [ 'bold' ] ),
                'warning'   => new FormatterStyler( 'black', 'yellow', [ 'bold' ] ),
                'error'     => new FormatterStyler( 'white', 'red', [ 'bold' ] ),
            ] );
        }

        /**
         * @param $message
         * @return mixed
         */
        public function format( $message ) {

            $message = preg_replace_callback( static::$placeholderRegexp, function( $matches ) {

                if( strpos( $matches[1], 'style:' ) !== false ) {

                    $styleParameters        = array_map( 'trim', explode( ',', str_replace( 'style:', '', $matches[1] ) ) );
                    $arguments              = [];

                    if( isset( $styleParameters[0] ) ) {
                        $arguments[]    = array_shift( $styleParameters );
                    }
                    if( isset( $styleParameters[0] ) ) {
                        $arguments[]    = array_shift( $styleParameters );
                    }
                    if( $styleParameters ) {
                        $arguments[]        = $styleParameters;
                    }

                    return ( new \ReflectionClass( __NAMESPACE__ . '\\FormatterStyler' ) )
                        ->newInstanceArgs( $arguments )->colorize( $matches[2] );
                } else if ( isset(  $matches[1]) && in_array( $matches[1], array_keys( $this->getStyles() ) ) ) {
                    return $this->getStyle( $matches[1] )->colorize( $matches[2] );
                }

            }, $message );

            return $message;
        }

        /**
         * @return array
         */
        public function getStyles() {
            return $this->styles;
        }

        /**
         * @param $name
         * @return FormatterStyler
         * @throws CliException
         */
        public function getStyle( $name ) {

            if( ! isset( $this->styles[ $name ] ) ) {
                throw new CliException( sprintf( 'Style "%s" not defined for formatter', $name ) );
            }

            return $this->styles[ $name ];
        }

        /**
         * @param array $styles
         * @return static
         */
        public function setStyles( array $styles = [] ) {
            $this->styles = $styles;
            return $this;
        }

    }