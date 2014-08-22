<?php
/**
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * WMCC CMS v0.2
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * WiseMon's «CyberCog» — Content Management System
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 * ...
 *
 * @package   Kernel
 * @version   $Id: Autoload.php 1 2009/07/09 02:10:01 Dmitry Romanyuta $
 * @since     File available since v0.2
 * @copyright Copyright (c) 2008-2009 CyberCog LLC (http://www.wmcc.su)
 * @license   http:// ... WMCC License 1.0
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

/**
 *  Автозагрузка класса
 *
 *  @param  string $name Имя класса
 *  @return void
*/

function __autoload($className)
{
    $arrayPathToClass = explode('_', $className);
    if ($arrayPathToClass[0] == 'WMCC') {
        $count = count($arrayPathToClass);
        for ($i=0; $i < $count; $i++) {
            if (($i + 1) != $count) {
                $pathToClass .= $arrayPathToClass[$i] . '/';
            } else {
                $pathToClass .= $arrayPathToClass[$count - 1] . '.php';
            }
        }
        if (file_exists($pathToClass) == true) {
            require_once realpath($pathToClass);
        }
    }
    else {
        $pathToClass = $className .".php";
        require_once realpath($pathToClass);
    }
}
?>
