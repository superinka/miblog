<?php 
    namespace App\Helpers;

    class Helper
    {
        public static function shout(string $string)
        {
            return strtoupper($string);
        }

        public static function pre($list,$exit=true){
            echo "<pre>";
            print_r($list);
            
            if($exit){
                die();
            }
        }
    }
?>