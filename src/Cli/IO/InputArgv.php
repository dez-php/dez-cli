<?php

    namespace Dez\Cli\IO;

    /**
     * Class InputArgv
     * @package Dez\Cli\IO
     */
    class InputArgv extends Input {

        /**
         * @return $this
         */
        protected function parse() {

            $tokens  = $this->getTokens();

            if( count( $tokens ) > 0 ) {

                for( $index = 0, $length = count( $tokens ); $index < $length; $index++ ) {

                    $token  = $tokens[ $index ];

                    if( strpos( $token, '--' ) === 0 && $token !== '--' ) {

                        $token      = explode( '=', $token );
                        $name       = $token[0];
                        $value      = ! isset( $token[1] ) ? true : trim( $token[1], '\'"' );

                        $this->setOption( substr( $name, 2 ), $value );

                    } else if ( strpos( $token, '-' ) === 0 && $token !== '-' ) {

                        $name       = substr( $token, 1 );
                        if( isset( $tokens[ $index + 1 ] ) && strpos( $tokens[ $index + 1 ], '-' ) !== 0 ) {
                            $this->setOption( $name[0], $tokens[ $index + 1 ] );
                            $index++;
                        } else {
                            $this->setOption( $name[0], substr( $name, 1 ) );
                        }

                    } else {
                        $this->setArgument( $index, $token );
                    }

                }

                unset( $tokens );

            }

            return $this;

        }

    }