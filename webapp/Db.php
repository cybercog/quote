<?php

class Db
{
    private static $db = array();
    private static $link;
    
    public static function connect($db)
    {
        self::$db = $db;
        self::$link = mysql_connect( self::$db['hostname'], self::$db['username'], self::$db['password'] );

        if( self::$link !== false ) {
            mysql_query( "SET NAMES 'utf8';" );
            mysql_query( "CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';" );

            if( self::selectDb() === false) {
                exit('Error select DB' . self::$db['name']);
            }

            return true;
        }
        else {
            exit('Error connect to DB MySQL.' . self::$db['hostname']);
        }
    }

    private static function selectDb()
    {
        return mysql_select_db( self::$db['name'], self::$link );
    }

    public static function disconnect()
    {
        return mysql_close( self::$link );
    }

    public static function query( $query )
    {
        return mysql_query( $query, self::$link );
    }

    public static function fetchArray( $result )
    {
        return mysql_fetch_array( $result, MYSQL_ASSOC );
    }

    public static function numRows( $result )
    {
        return mysql_num_rows( $result );
    }
}