<?php

    header( 'Content-Type: text/html; charset=UTF-8' );

    require_once 'Config.php';
    //require_once 'Autoload.php';
    require_once 'Db.php';
    require_once 'Authorization.php';

    Db::connect($db);
    // ^^^

    session_start();

    if (isset($_GET['logoff']) && $_GET['logoff'] == 1 && isset($_SESSION['password']) && $_SESSION['password'] != '') {
        Authorization::logoff();
    }

    $secured_password = Authorization::check($access);


    // If we trying to add new Quote
    if ( isset($_GET['add_quote']) && $_GET['add_quote'] == 1 && isset($_POST['try_add']) && $_POST['try_add'] == 1 && isset($_SESSION['password']) && $_SESSION['password'] == $secured_password ) {

        $quote_text = trim($_POST['quote_text']);
        $author_id = $_POST['author'];

        if ( $quote_text != "" && $author_id > 0 ) {

            Db::query("
                           INSERT INTO
                                            `quotes`
                                            (
                                             `q_id`,
                                             `q_text`,
                                             `author_id`,
                                             `q_timestamp`,
                                             `q_active`
                                            )
                                  VALUES
                                            (
                                             '0',
                                             '". $quote_text ."',
                                             '". $author_id ."',
                                             '". time() ."',
                                             '1'
                                            )  ;");
            Navigation::Redirect();
        }
    }
    elseif (isset($_GET['add_author']) && isset($_GET['add_author']) && $_GET['add_author'] == 1 && isset($_POST['try_add']) && $_POST['try_add'] == 1 && isset($_SESSION['password']) && $_SESSION['password'] == $secured_password ) {

        $author_name = trim($_POST['author_name']);
        $author_fullname = trim($_POST['author_fullname']);
        $author_bio = trim($_POST['author_bio']);
        $author_born = trim($_POST['author_born']);
        $author_died = trim($_POST['author_died']);

        $author_name == "" ? $errors['author_name'] = "empty_value" : $author_name;

        if ( count($errors) == 0 ) {
            print $author_bio;
        /*
            Db::query("
                           INSERT INTO
                                            `authors`
                                            (
                                             `a_id`,
                                             `a_name`,
                                             `a_fullname`,
                                             `a_bio`,
                                             `a_born`,
                                             `a_died`
                                            )
                                  VALUES
                                            (
                                             '0',
                                             '". $author_name ."',
                                             '". $author_fullname ."',
                                             '". $author_bio ."',
                                             '". $author_born ."',
                                             '". $author_died ."'
                                            )  ;") or die ("ble");
            Navigation::Redirect();
            */
        }
    }

?>

<!doctype html>
<html>
    <head>
        <title>Quoter</title>
        <meta charset="utf-8" />
        <link href="styles/main.css" rel="stylesheet" type="text/css" media="screen" />
        <script type="text/javascript" src="scripts/interface.js"></script>
    </head>
    
    <body>
        <img src="images/bg_body.gif" alt="Body background" class="hidden" />
        <div id="logo"><a href="."><img src="images/logo.gif" alt="Цитатник" /></a></div>
        
        <?php
            // Controllers template
            if ( isset($_SESSION['password']) && $_SESSION['password'] == $secured_password ) {
                echo '
                        <div class="menu">
                            <a href="?add_quote=1">Добавить цитату</a>
                            <a href="?add_author=1">Добавить автора</a>
                        </div>
                        ';
            }
        
            // Authorization template
            if ( ! isset($_SESSION['password']) && $_SESSION['password'] != $secured_password ) {
                echo '
                    <div id="auth">
                        <form method="post">
                            <input type="password" name="password" value="" />
                            <input type="submit" value="Авторизоваться!" />
                        </form>
                    </div>
                    ';
            }
            else {
                echo '<div id="auth"><a href="?logoff=1">Выйти</a></div>';
            }

            // Let's check, if we want to add quotes!
            if (isset($_GET['add_quote']) && $_GET['add_quote'] == 1 && isset($_SESSION['password']) && $_SESSION['password'] == $secured_password ) {
                
                $q = Db::query("
                                        SELECT
                                                    *
                                          FROM
                                                    `authors`
                                     ORDER BY
                                                    `a_name`
                                            ASC
                                    ;");
                                    
                $authors_count = Db::numRows($q);
                
                if ( $authors_count > 0 ) {
                    $i = 0;
                    $authors_data = array();
                    while ($r = Db::fetchArray($q)) {
                        $authors_data[$i]['id'] = $r['a_id'];
                        $authors_data[$i]['name'] = $r['a_name'];
                        $i++;
                    }
                }
                else {
                    // Добавить автора
                }
            
        ?>
            
                <!-- START. ADD QUOTE WRAPPER. -->
                <div id="wrapper">
                    <div class="refresh"><a href="."><img src="images/refresh.gif" alt="Обновить" /><span class="link">Случайная цитата</span></a></div>
                    <!--
                    <div class="quote_add float-right">
                        <span class="active">
                            <img src="images/refresh.gif" alt="Обновить" />
                            <span class="link">Добавить цитату</span>
                        </span>
                    </div>
                    -->
                    <form method="post">
                        <input type="hidden" name="try_add" value="1" />
                        <blockquote>
                            <textarea class="quote_text w-100" name="quote_text"></textarea>
                            <div class="button_row align-right">
                                <input type="submit" class="button" value="Добавить цитату!" />
                            </div>
                        </blockquote>
                        <div class="author">
                            <label for="author">Автор цитаты:</label>
                            <select name="author" id="author">
                                <option class="selected" selected="selected" disabled="disabled" value="0">Выберите автора цитаты</option>
                                <?php
                                foreach ( $authors_data as $key => $value ) {
                                    echo '<option value="'. $value['id'] .'">'. $value['name'] .'</option>';
                                }
                                ?>
                            </select>
                            <div>
                                <a href="?add_author=1">+ добавить автора</a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- END. ADD QUOTE WRAPPER. -->
            <?php
            }
            // Or maybe we we are going to add new authors!
            elseif ( isset($_GET['add_author']) && $_GET['add_author'] == 1 && isset($_SESSION['password']) && $_SESSION['password'] == $secured_password ) {
            ?>
                <!-- START. ADD AUTHOR TEMPLATE. -->
                <div id="wrapper">
                    <div class="refresh"><a href="."><img src="images/refresh.gif" alt="Обновить" /><span class="link">Случайная цитата</span></a></div>
                    <?php
                        /*
                        if ( isset($_SESSION['password']) && $_SESSION['password'] == $secured_password ) {
                            echo '
                                    <div class="quote_add float-right">
                                        <a href="?add_quote=1">
                                            <img src="images/refresh.gif" alt="Обновить" />
                                            <span class="link">Добавить цитату</span>
                                        </a>
                                    </div>
                                    ';
                        }
                        */
                    ?>
                    <form method="post" onsubmit='return defaultChecks()'>
                        <input type="hidden" name="try_add" value="1" />
                        <blockquote>
                            &ldquo;Пример текста цитаты (эх, хорошо бы было написать здесь что-нибудь про авторов цитат...)&rdquo;
                        </blockquote>
                        <div class="author">
                            <input type="text" class="field w-400p" name="author_name" value="Сокращённое имя автора" onFocus="clearText(this)" onBlur="restoreText(this)" />
                        </div>     
                        <div class="about_author">
                            <img class="popup-arrow" src="images/arrow_big-top.gif" alt="^" />
                            <h3 class="weight-normal">
                                <input type="text" class="field w-100" name="author_fullname" value="Полное имя автора" onFocus="clearText(this)" onBlur="restoreText(this)" />
                            </h3>
                            <h5 class="weight-normal">
                                <input type="text" class="field w-47" name="author_born" value="дата рождения" onFocus="clearText(this)" onBlur="restoreText(this)" />
                                &mdash;
                                <input type="text" class="field w-47" name="author_died" value="дата смерти" onFocus="clearText(this)" onBlur="restoreText(this)" />
                            </h5>
                            <p class="author_bio">
                                <textarea name="author_bio" id="bio" class="w-100" onFocus="clearText(this)" onBlur="restoreText(this)">Об авторе... с чувством, толком, расстановкой.</textarea>
                            </p>
                            <div class="button_row">
                                <input type="submit" class="button" value="Добавить автора!" />
                            </div>                            
                        </div>
                    </form>
                </div>
                <!-- END. ADD AUTHOR TEMPLATE. -->
                
        <?php
            }
            // >_< Noes! we just looking content!
            else {
                $query = Db::query("
                                            SELECT
                                                        *
                                               FROM
                                                        `quotes`, `authors`
                                             WHERE
                                                        `q_active` = '1'
                                                 AND
                                                        `author_id` = `a_id`
                                        ;");

                if ( Db::numRows($query) > 0 ) {
                    $quotes_array = array();
                    while ( $result = Db::fetchArray($query) ) {
                        ! isset( $quotes_counter ) ? $quotes_counter = 0 : $quotes_counter++;
                        $quotes_array[] = $result;
                    }
                }

                $random_key = rand( 0, $quotes_counter );

                $quote_text = $quotes_array[$random_key]['q_text'];
                $author_name = $quotes_array[$random_key]['a_name'];
                $author_fullname = $quotes_array[$random_key]['a_fullname'];
                $author_bio = $quotes_array[$random_key]['a_bio'];

                // Living dates
                if ($quotes_array[$random_key]['a_born'] == "") {
                    $quotes_array[$random_key]['a_born'] = "?";
                }

                if ($quotes_array[$random_key]['a_born'] == $quotes_array[$random_key]['a_died']) {
                    $author_living = $quotes_array[$random_key]['a_born'];
                }
                else {
                    $author_living = $quotes_array[$random_key]['a_born'] ." — ". $quotes_array[$random_key]['a_died'];
                }
        ?>
        
                <!-- START. SHOW QUOTE WRAPPER. -->
                <div id="wrapper">
                    <div class="refresh"><a href="."><img src="images/refresh.gif" alt="Обновить" /><span class="link">Случайная цитата</span></a></div>
                    <?php
                        /*
                        if ( isset($_SESSION['password']) && $_SESSION['password'] == $secured_password ) {
                            echo '
                                    <div class="quote_add float-right">
                                        <a href="?add_quote=1">
                                            <img src="images/refresh.gif" alt="Обновить" />
                                            <span class="link">Добавить цитату</span>
                                        </a>
                                    </div>
                                    ';
                        }
                        */
                    ?>
                    <blockquote>
                        &ldquo;<?php print $quote_text; ?>&rdquo;
                    </blockquote>
                    <div class="author">
                        <a href="javascript:void(0);"><?php print $author_name; ?></a>
                    </div>            
                    <div class="about_author">
                        <img class="popup-arrow" src="images/arrow_big-top.gif" alt="^" />
                        <h3 class="weight-normal"><?php print $author_fullname; ?></h3>
                        <h5 class="weight-normal"><?php print $author_living; ?></h5>
                        <p class="author_bio">
                            <?php print $author_bio; ?>
                        </p>
                    </div>
                </div>
                <!-- END. SHOW QUOTE WRAPPER. --> 
                
        <?php            
            }
        ?>
        
        
        
        <div id="footer">
            <p class="copyright">
                WiseMon's <a href="http://cybercog.su/">&laquo;CyberCog&raquo;</a>
            </p>
        </div>
    </body>
</html>