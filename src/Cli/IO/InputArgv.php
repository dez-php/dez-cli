<?php

    namespace Dez\Cli\IO;

    class InputArgv extends Input {

        protected function parse() {

            $tokens  = $this->getTokens();

            if( count( $tokens ) > 0 ) {

                $index  = 0;

                for( $index = 0, $length = count( $tokens ); $index < $length; $index++ ) {

                    $token  = $tokens[ $index ];

                    if( strpos( $token, '--' ) === 0 && $token !== '--' ) {

                        list( $name, $value )   = explode( '=', $token );
                        $this->setOption( substr( $name, 2 ), $value );

                    } else if ( strpos( $token, '-' ) === 0 && $token !== '-' ) {

                        $name       = substr( $token, 1 );
                        $nextValue  = $tokens[ $index + 1 ];

                        if( $nextValue !== null && strpos( $nextValue, '-' ) !== 0 ) {
                            $index++;
                            $this->setOption( $name[0], $nextValue );
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