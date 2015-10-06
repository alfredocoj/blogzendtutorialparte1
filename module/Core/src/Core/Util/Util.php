<?php
/**
 * Created by PhpStorm.
 * User: jhordan
 * Date: 06/08/15
 * Time: 13:26
 */

namespace Core\Util;


class Util {

    public static function processErros( array $erros ){

        foreach( $erros as $erro ){
            if( is_array( $erro ) )
                foreach ( $erro as $value )
                    yield $value;
            elseif( is_string( $erro ) )
                yield  $erro;
        }

    }
}
