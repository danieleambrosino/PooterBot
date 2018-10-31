<?php
/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
require_once './templates/head.php';
if ( DEVELOPMENT )
{
  ?>
<a href="functions/checkLogin.php" class="btn">Login</a>
  <?php
}
else
{
  ?>
  <body>
    <script async src="https://telegram.org/js/telegram-widget.js?5" data-telegram-login="PooterBot" data-size="large" data-auth-url="/web/checkLogin.php"></script>
  </body>
  <?php
}