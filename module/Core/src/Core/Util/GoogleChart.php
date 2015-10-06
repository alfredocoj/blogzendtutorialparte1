<?php

namespace Core\Util;


class GoogleChart {

    private $options;
    private $cols;
    private $rows;

    private $typeAvailable = [ "string", "number", "boolean" ];
    private $formatAvailable = [ "none", "decimal", "scientific", "currency", "percent", "short", "long" ];

    public function __construct( $title , $format = "decimal" ){
        $this->options['title'] = is_string( $title ) ? $title : null ;
        $this->options['format'] = in_array( $format , $this->formatAvailable ) ? $format : null ;
        $this->options['status'] = true ;
        $this->options['message'] = "Success Json receiver!" ;
    }

    public function addCol( $label = null, $type = "string", $id = null, $role = null ){

        if( ( ( is_string( $label ) && is_null( $role ) ) || ( is_string( $role ) && is_null( $label ) ) ) && in_array( $type , $this->typeAvailable ) ) {

            $this->cols[] = [ "id" => $id, "label" => $label, "type" => $type, "role" => $role, ];

        } else
            throw new \Exception( "Os argumentos do método addCol são invalidos!" );

        return $this;
    }

    public static function catchReturn( $message = "Error!"){
        return [ 'options' => [ 'status' => false, 'message' => is_string( $message ) ? $message : "Error" ] ];
    }

    public function addColRole( $role ){
        return is_string( $role ) ? $this->addCol( null, "string", null, $role ) : $this ;
    }

    public function addColNumber( $label , $id = null ){
        return is_string( $label ) ? $this->addCol( $label, "number", $id, null ) : $this ;
    }

    public function addColText( $label , $id = null ){
        return is_string( $label ) ? $this->addCol( $label, "string", $id, null ) : $this ;
    }

    public function addRow(){

        if( $arguments = func_get_args() ){
            if( func_num_args() > count( $this->cols ) )
                throw new \Exception( "O número de argumentos é maior que o número de colunas" );

            $dataValue = [];

            foreach( $arguments as $value )
                $dataValue[] = !is_array( $value ) ? [ "v" => $value ] : null ;

            $this->rows[] = [ "c" => $dataValue ];

        } else
            throw new \Exception( "O método addRow precisa ter argumentos" );

        return $this;
    }

    public function addRowArray( array $data ){

        if( count( $data ) > count( $this->cols ) )
            throw new \Exception( "O número de argumentos é maior que o número de colunas" );

        $dataValue = [];

        foreach( $data as $value )
            $dataValue[] = !is_array( $value ) ? [ "v" => $value ] : null ;

        $this->rows[] = [ "c" => $dataValue ];

        return $this;

    }

    public function exchangeArray( array $data ){

        if( is_array( $data[0] ) ) {

            foreach( $data[0] as $key => $value )
                is_numeric( $value ) ? $this->addColNumber( $key, $key ) : $this->addColText( $key, $key ) ;

            foreach( $data as $value)
                $this->addRowArray( iterator_to_array( $this->processArray( $value )) );


        } else
            throw new \Exception( "O método exchangeArray precisa receber uma matriz!" );

        return $this;
    }

    private function processArray( array $data ){
        foreach( $data as $value )
            yield is_numeric( $value ) ? (float) $value: $value ;
    }

    public function convertColToRole( $colLabel , $role ){

        if( is_array( $this->cols ) && is_string( $colLabel ) && is_string( $role ) ){

            foreach( $this->cols as $key => $col ) {

                if ( $col['label'] == $colLabel ) {

                    $this->cols[$key]['role'] = $role;
                    $this->cols[$key]['label'] = null;

                }

            }

        } else
            throw new \Exception("É necessário adicionar ao menos uma coluna para usar o método convertColToRole!");

        return $this;
    }

    public function setSize( $width , $height ){

        if( ( is_numeric( $width ) || is_integer( $width ) ) && ( is_numeric( $height ) || is_integer( $height ) ) ) {

            $this->options['width'] = $width;
            $this->options['height'] = $height;

        } else
            throw new \Exception( "É necessário inserir valores números ou inteiros no método setSize." );

        return $this;
    }

    public function processData(){

        if( is_null( $this->cols ) || empty( $this->cols ) || is_null( $this->rows ) || empty( $this->rows ) )
            throw new \Exception( "É obrigatório adicionar colunas e linhas!" );

        if( !is_array( $this->cols ) || !is_array( $this->rows ) )
            throw new \Exception( "Colunas ou Linhas Invalidas!" );

        return [ 'options' => $this->options , 'cols' => $this->cols, 'rows' => $this->rows ];

    }
}
