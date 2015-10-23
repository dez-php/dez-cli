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
        protected $colorizers   = [];

        /**
         * @var string
         */
        static protected $placeholderRegexp     = '~\[([^]]+)\](.*)\[\/[^]]+]~Uuis';

        /**
         * @var string
         */
        static protected $attrRegexp            = '~(?:(fg|bg|extra)=["\']{1}([a-z,]+)["\']{1})~Uuis';

        /**
         * Constructor
         */
        public function __construct() {
            $this->setColorizers( [
                'info'      => new Colorizer( 'green', false, [ 'bold' ] ),
                'success'   => new Colorizer( 'cyan', false, [ 'bold' ] ),
                'warning'   => new Colorizer( 'black', 'yellow', [ 'bold' ] ),
                'error'     => new Colorizer( 'white', 'red', [ 'bold' ] ),
            ] );
        }

        /**
         * @param $message
         * @return mixed
         */
        public function format( $message ) {

            $message = preg_replace_callback( static::$placeholderRegexp, function( $matches ) {

                $styleType      = $matches[1];
                $tagName        = preg_split( '/\s+/uis', $styleType )[0];
                $message        = $matches[2];

                if( strpos( $tagName, 'style' ) === 0 ) {
                    $colorizer  = new Colorizer();
                } else if ( in_array( $tagName, array_keys( $this->getColorizers() ) ) ) {
                    $colorizer = clone $this->getColorizer( $tagName );
                } else {
                    return $message;
                }

                if( preg_match( static::$attrRegexp, $styleType ) ) {
                    preg_match_all( static::$attrRegexp, $styleType, $attributes );
                    if( isset( $attributes[1] ) && count( $attributes[1] ) > 0 ) {
                        foreach( $attributes[1] as $index => $attributeName ) {
                            if( $attributeName == 'fg' ) {
                                $colorizer->setForegroundColor( $attributes[2][$index] );
                            } else if( $attributeName == 'bg' ) {
                                $colorizer->setBackgroundColor( $attributes[2][$index] );
                            } else if( $attributeName == 'extra' ) {
                                $options    = explode( ',', $attributes[2][$index] );
                                $colorizer->setOptions( $options );
                            }
                        }
                    }
                }

                return $colorizer->colorize( $message );

            }, $message );

            return $message;
        }

        /**
         * @return array
         */
        public function getColorizers() {
            return $this->colorizers;
        }

        /**
         * @param $name
         * @return Colorizer
         * @throws CliException
         */
        public function getColorizer( $name ) {

            if( ! isset( $this->colorizers[ $name ] ) ) {
                throw new CliException( sprintf( 'Colorizer "%s" not defined for formatter', $name ) );
            }

            return $this->colorizers[ $name ];
        }

        /**
         * @param $name
         * @param Colorizer $colorizer
         * @return static
         */
        public function setColorizer( $name, Colorizer $colorizer ) {
            $this->colorizers[ $name ] = $colorizer;
            return $this;
        }

        /**
         * @param array $colorizers
         * @return static
         */
        public function setColorizers( array $colorizers = [] ) {
            foreach( $colorizers as $name => $colorizer ) {
                $this->setColorizer( $name, $colorizer );
            }
            return $this;
        }

    }