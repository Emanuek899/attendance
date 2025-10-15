<?php
/**
 * Component that contains helpers for expected error of database and
 * format them in a friendly and clear way
 */
class Parser{
    public static function dbDuplicateErrorParser(string $dbErrorMsg){
        if (preg_match("/Duplicate entry '(.+)' for key '(.+)'/", $dbErrorMsg, $matches)) {
            return $matches[2]; 
        }
    }

    public static function dbColumnNotFoundParser(string $dbErrorMsg){
        if (preg_match("/Unknown column '(.+)' in '(.+)'/", $dbErrorMsg, $matches)) {
            return $matches[1]; 
        }
    }
}