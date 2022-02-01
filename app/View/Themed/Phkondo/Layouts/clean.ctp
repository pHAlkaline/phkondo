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
 * @since         pHKondo v 1.6.2
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
            <?php echo $headerTitle; ?>&nbsp;<?php echo Configure::read('Theme.owner_name'); ?>
        </title>

        <?php
        echo $this->Html->meta('icon');
        echo $this->fetch('meta');
        ?>
        <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100;0,200;0,300;0,400;0,500;0,531;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,531;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <?php
        echo $this->Html->css(array(
            'animate/animate.min',
            //'bootstrap/bootstrap-glyphicons',
            'bootstrap/font-awesome.min',
            'bootstrap/bootstrap',
            'bootstrap/bootstrap-theme',
            'datepicker/datepicker-bootstrap-theme',
            //'datepicker/bootstrap-datepicker3.min',
            'select2/select2',
            'select2/select2-bootstrap',
            'select2/select2.phkondo',
            'offcanvas',
            'checkbox-radio-styling/checkbox-radio',
            'phkondo',
        ));
        echo $this->Html->css(array('phkondo_print'), null, array('media' => 'print'));

        echo $this->fetch('css');
        ?>

    </head>

    <body>

        <div id="main-container">
            <div id="content" class="container">
                <div class="row hidden-print">
                    <?php if (isset($breadcrumbs)) echo $this->element('breadcrumbs', array('breadcrumbs', $breadcrumbs)); ?>
                    <div class="col-sm-12">
                        <p>&nbsp;</p>
                        <?php echo $this->Flash->render(); ?>
                    </div>
                </div>
                <?php echo $this->fetch('content'); ?>
            </div><!-- #header .container -->

            <div id="footer" class="container hidden-print">
                <div style="text-align: center;">Copyright (c) pHAlkaline (<a href="http://phalkaline.net" target="_blank">http://phalkaline.net</a>)</div>
                <?php //Silence is golden      ?>
            </div><!-- #footer .container -->

        </div><!-- #main-container -->

        <!--div class="container">
                <div class="well">
                        <small>
        <?php //echo $this->element('sql_dump');      ?>
                        </small>
                </div>
        </div><!-- .container -->
        <?php
        echo $this->Html->script(array('libs/jquery-3.5.1', 'libs/bootstrap.min'));
        echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.min'));
        echo $this->Html->script(array('libs/select2/select2.full'));
        echo $this->Html->script(array('libs/offcanvas'));


        switch (Configure::read('Config.language')) {
            case 'por':
                echo $this->Html->script(array('libs/select2/i18n/pt'));
                echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.pt.min'));
                break;
            case 'eng':
                echo $this->Html->script(array('libs/select2/i18n/en'));
                echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.en-GB.min'));
                break;
            case 'ita':
                echo $this->Html->script(array('libs/select2/i18n/it'));
                echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.it.min'));
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
        ?>

        <script type="text/javascript">
            $(document).ready(function () {
                $("form").submit(function () {
                    // prevent duplicate form submissions
                    $(this).find(":submit").attr('disabled', 'disabled').prepend(' <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> ');
               ;
                });
                var phkondolang = 'en-GB';
                switch (phkondo.APP_LANG) {
                    case 'por':
                        phkondolang = 'pt';
                        break;
                    case 'ita':
                        phkondolang = 'it';
                        break;
                }
                $('.datefield').datepicker({
                    format: "<?php echo Configure::read('calendarDateFormat'); ?>",
                    weekStart: 1,
                    language: phkondolang,
                    todayHighlight: true
                });
                $('.datefield').attr('autocomplete', 'off');

                $('select').select2({
                    theme: "bootstrap"}
                );
                $("li.disabled").find('a').removeAttr("href");
                $("li.disabled").find('a').removeAttr("onclick");
            });
        </script>
        <?php
        echo $this->fetch('script');
        ?>
    </body>

</html>
