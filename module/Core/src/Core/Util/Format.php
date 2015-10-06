<?php

namespace Core\Util;
use Zend\Stdlib\DateTime;

class Format
{
    public static function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
         for ($i = 0; $i<=strlen($mask)-1; $i++) {
               if ($mask[$i] == '#') {
                  if(isset($val[$k]))
                       $maskared .= $val[$k++];
               } else {
                 if(isset($mask[$i]))
                 $maskared .= $mask[$i];
             }
         }

         return $maskared;
    }

    /**
    * Função para formatação de DATA.
    * Ex. formatDate('2013-08-10','Y-m-d','d/m/Y') => 10/08/2013
    */

    public static function formatDate($data,$entrada,$saida)
    {
        $val = \DateTime::createFromFormat($entrada,$data);
        return $val->format($saida);
    }

    /**
    * Retorna apenas nos numeros de uma String
    */

    public static function onlyNumber($str)
    {
      return preg_replace("/[^0-9]/", "", $str);
    }

    public static function removeMaskPhone($str)
    {
      return  str_replace(" ","",$str);
    }

    public static function secondsToTime($seconds) {
        // extract hours
        $hours = floor($seconds / (60 * 60));

        // extract minutes
        $divisor_for_minutes = $seconds % (60 * 60);
        $minutes = floor($divisor_for_minutes / 60);

        // extract the remaining seconds
        $divisor_for_seconds = $divisor_for_minutes % 60;
        $seconds = ceil($divisor_for_seconds);

        // return the final array
        $obj = array(
            "h" => (int) $hours,
            "m" => (int) $minutes,
            "s" => (int) $seconds,
        );
        return $obj;
    }

    public static function tofloat($num) {
      $dotPos = strrpos($num, '.');
      $commaPos = strrpos($num, ',');
      $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
          ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

      if (!$sep) {
          return floatval(preg_replace("/[^0-9]/", "", $num));
      }

      return floatval(
          preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
          preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
      );
    }

    public static function converte_data($data) {
      /*
       * Caso a data tenha horas,
       * separa a data da hora.
       */
      $hora = '';

      if (strstr($data, ' ')) {
          $data = explode(' ', $data);

          $hora = $data[1];
          $data = $data[0];
      }

      /*
       * Reorganiza a data para ficar
       * no padrão americano.
       * yyyy-mm-dd hh:mm:ss
       */
      $data = explode('/', $data);
      $data = array_reverse($data);
      $data = implode('-',$data);

      /*
       * Se a data possui hora,
       * a função retorna a data e hora.
       * Caso não exista hora,
       * retorna apenas a data
       */
      if ($hora != '') {
          return $data . ' ' . $hora;
      }
      else {
          return $data;
      }

    }
}
