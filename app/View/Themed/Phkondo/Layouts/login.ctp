<?php
/**
 *
 * pHKondo : pHKondo software for condominium property managers (http://phalkaline.eu)
 * Copyright (c) pHAlkaline . (http://phalkaline.eu)
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
 * @copyright     Copyright (c) pHAlkaline . (http://phalkaline.eu)
 * @link          http://phkondo.net pHKondo Project
 * @@package      app.View.Themed.Layouts
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
?>
<?php
if (!isset($headerTitle)){
    $headerTitle='';
}
?>
<!DOCTYPE html>
<html >

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $headerTitle; ?>&nbsp;<?php echo Configure::read('Theme.owner_name'); ?>
        </title>

        <?php
        echo $this->Html->meta('icon');
        echo $this->fetch('meta');
        echo $this->Html->css(array(
            'bootstrap/bootstrap-glyphicons',
            'bootstrap/font-awesome.min',
            'bootstrap/bootstrap',
            'bootstrap/bootstrap-theme',
            'phkondo'));
        echo $this->Html->css(array('phkondo_print'), null, array('media' => 'print'));
        echo $this->fetch('css');
        ?>
        <?php
        echo $this->Html->script(array('libs/jquery-2.2.2.min', 'libs/bootstrap.min'));
        ?>

        <script type="text/javascript">
            $(document).ready(function () {

        
            });
        </script>
    </head>

    <body class="hold-transition login-page">
       <?php echo $this->fetch('content'); ?>

        
    </body>
   
</html>
