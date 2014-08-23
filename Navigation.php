<?php

class Navigation
{
    public static function Redirect ()
    {
        $hostname = "http://". $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
    
        if ( $_SESSION['wmcc_trace_last'] == $_SERVER['QUERY_STRING'] )
        {
            $redirect_url = $_SESSION['wmcc_trace_prev'];
        }
        else
        {
            $redirect_url = $_SESSION['wmcc_trace_last'];
        }

        echo "<html>
                    <meta http-equiv=\"refresh\" content=\"0;url=".$hostname."\" />
                    <body>
                        Вы можете <a href=\"".$hostname."\">вернуться на главную страницу</a>.<br />
                    </body>
              </html>";
        exit("(Автопереход на главную страницу включен!)");
        
        return true;
    }
}