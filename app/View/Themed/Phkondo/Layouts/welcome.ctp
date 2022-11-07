<?php

/**
 *
 * pHKondo : pHKondo software for condominium property managers (http://phalkaline.net)
 * Copyright (c) pHAlkaline . (http://phalkaline.net)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @copyright     Copyright (c) pHAlkaline . (http://phalkaline.net)
 * @link          https://phkondo.net pHKondo Project
 * @@package      app.View.Themed.Layouts
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 *
 */
?>
<?php
if (!isset($headerTitle)) {
    $headerTitle = '';
}
?>
<!DOCTYPE html>
<html >

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo $this->Html->charset(); ?>
        <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <title>
            <?php echo $headerTitle; ?>&nbsp;
        </title>

        <?php
        echo $this->Html->meta('icon');
        echo $this->fetch('meta');
        ?>
        <link href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
        <?php
        echo $this->Html->css(array(
            'bootstrap/bootstrap',
            'animate/animate.min',
            'phkondo'));
        ?>
        <style>
            .centered {
                position: fixed;
                top: 25%;
                left: 50%;
                /* bring your own prefixes */
                transform: translate(-50%, -50%);
            }
        </style>
    </head>

    <body>
        <div class="container">
            <?php echo $this->fetch('content'); ?>
        </div>
        <div style="position:fixed;bottom:0;left:50%;transform: translate(-50%, -50%);">
             <?php echo $this->Flash->render(); ?>
        </div>
    </body>
    <?php
    echo $this->Html->script(array('libs/jquery-2.2.2.min', 'libs/bootstrap.min'));
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            const myClickAnchor = setTimeout(clickAnchor, 3000);

            function clickAnchor() {
                $('#go-pHKondo')[0].click();
            }
        });
    </script>
</html>
