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
            'datepicker/bootstrap-datepicker3.min',
            'select2/select2',
            'select2/select2.bootstrap',
            'offcanvas',
            'phkondo'));
        echo $this->Html->css(array('phkondo_print'), null, array('media' => 'print'));

        echo $this->fetch('css');
        ?>

    </head>

    <body>

        <div id="main-container">

            <div id="header" class="container hidden-print">
                <?php echo $this->element('menu/top_menu', array('headerDescription' => '')); ?>
            </div><!-- #header .container -->

            <div id="content" class="container">
                <div class="hidden-print">
                    <?php if (isset($breadcrumbs)) echo $this->element('breadcrumbs', array('breadcrumbs', $breadcrumbs)); ?>
                    <?php echo $this->Flash->render(); ?>
                </div>
                <?php echo $this->fetch('content'); ?>
            </div><!-- #header .container -->

            <div id="footer" class="container hidden-print">
                <div style="text-align: center;">Copyright (c) pHAlkaline (<a href="http://phalkaline.eu" target="_blank">http://phalkaline.eu</a>)</div>
                <?php //Silence is golden     ?>
            </div><!-- #footer .container -->

        </div><!-- #main-container -->

        <!--div class="container">
                <div class="well">
                        <small>
        <?php //echo $this->element('sql_dump');     ?>
                        </small>
                </div>
        </div><!-- .container -->
 <?php
        echo $this->Html->script(array('libs/jquery-2.2.2.min', 'libs/bootstrap.min'));
        echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.min'));
        echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.pt.min'));
        echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.en-GB.min'));
        echo $this->Html->script(array('libs/select2/select2'));
        echo $this->Html->script(array('libs/offcanvas'));


        switch (Configure::read('Config.language')) {
            case 'por':
                echo $this->Html->script(array('libs/select2/select2_locale_pt-PT'));
                break;
            case 'eng':
                echo $this->Html->script(array('libs/select2/select2_locale_en'));
                break;
        }
        $phkondo = array(
            'APP_PATH' => Router::url('/', true),
            'APP_LANG' => Configure::read('Config.language'),
            'START_DATE' => date('d-m-Y', strtotime("-1 year", time())),
            'END_DATE' => date('d-m-Y', strtotime("+1 year", time())),
            'SEARCH_HERE_FOR_A_CLIENT' => __('Search')
        );
        echo $this->Html->scriptBlock('var phkondo = ' . $this->Js->object($phkondo) . ';');
        echo $this->fetch('script');
        ?>

        <script type="text/javascript">
            $(document).ready(function () {

                var phkondolang = 'en-GB';
                switch (phkondo.APP_LANG) {
                    case 'por':
                        phkondolang = 'pt';
                        break;
                }
                $('.datefield').datepicker({
                    format: "<?php echo  Configure::read('calendarDateFormat'); ?>",
                    weekStart: 1,
                    language: phkondolang,
                    todayHighlight: true
                });

                $('select').select2();
                $("li.disabled").find('a').removeAttr("href");
                $("li.disabled").find('a').removeAttr("onclick");
            });
        </script>
    </body>

</html>