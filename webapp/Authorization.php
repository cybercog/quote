<?php

class Authorization
{
    public static function check($access)
    {
        $secured_password = sha1(md5($access['password']));
        if ( isset($_POST['password']) && $_POST['password'] != "" ) {
            $posted_password = sha1(md5($_POST['password']));

            if ( $secured_password == $posted_password ) {
                self::logon($posted_password);
            }
        }
        
        return $secured_password;
    }
    
    private static function logon($posted_password)
    {
        $_SESSION['password'] = $posted_password;
        
        return true;
    }

    public static function logoff()
    {
        $_SESSION['password'] = "";
        
        return true;
    }
}