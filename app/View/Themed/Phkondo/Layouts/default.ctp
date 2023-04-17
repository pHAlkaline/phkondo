<?php

/**
 *
 * pHKondo : pHKondo software for condominium hoa association management (https://phalkaline.net)
 * Copyright (c) pHAlkaline . (https://phalkaline.net)
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
 * @copyright     Copyright (c) pHAlkaline . (https://phalkaline.net)
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
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo $this->Html->charset(); ?>
    <meta name="author" content="pHAlkaline">
    <meta name="generator" content="pHAlkaline">
    <meta name="robots" content="index, folow">
    <meta name="revisit-after" content="7 days">
    <meta name="rating" content="general">
    <meta name="keywords" content="software, HOA, property, condo, condominium, association, managers, management, free, opensource, white labelling">
    <meta name="description" content="pHKondo Condominium Hoa Association Management Software Includes Free and Open Source Version">
    <meta property="og:title" content="pHKondo Condominium Hoa Association Management Software">
    <meta property="og:site_name" content="pHKondo">
    <meta property="og:url" content="https://phkondo.net">
    <meta property="og:description" content="pHKondo Condominium Hoa Association Management Software Includes Free and Open Source Version">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://phkondo.net/img/logo_phkondo_flat.svg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@http://phkondo.net">
    <meta name="twitter:title" content="pHKondo Condominium Hoa Association Management Software">
    <meta name="twitter:description" content="pHKondo Condominium Hoa Association Management Software Includes Free and Open Source Version">
    <meta name="twitter:image" content="https://phkondo.net/img/logo_phkondo_flat.svg">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100;0,200;0,300;0,400;0,500;0,531;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,531;1,600;1,700;1,800;1,900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" integrity="sha512-i8+QythOYyQke6XbStjt9T4yQHhhM+9Y9yTY1fOxoDQwsQpKMEpIoSQZ8mVomtnVCf9PBvoQDnKl06gGOOD19Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <?php
    echo $this->Html->css(array(
        'animate/animate.min',
        //'bootstrap/bootstrap-glyphicons',
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
            <div style="text-align: center;">Copyright (c) pHAlkaline (<a href="https://phalkaline.net" target="_blank">https://phalkaline.net</a>)</div>
            <?php //Silence is golden      
            ?>
        </div><!-- #footer .container -->

    </div><!-- #main-container -->

    <!--div class="container">
                <div class="well">
                        <small>
        <?php //echo $this->element('sql_dump');      
        ?>
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
        case 'pt-br':
            echo $this->Html->script(array('libs/select2/i18n/pt-BR'));
            echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.pt-BR.min'));
            break;
        case 'eng':
            echo $this->Html->script(array('libs/select2/i18n/en'));
            echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.en-GB.min'));
            break;
        case 'ita':
            echo $this->Html->script(array('libs/select2/i18n/it'));
            echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.it.min'));
            break;
        case 'spa':
            echo $this->Html->script(array('libs/select2/i18n/es'));
            echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.es.min'));
            break;
    }
    $phkondo = array(
        'APP_PATH' => Router::url('/', true),
        'APP_LANG' => Configure::read('Config.language'),
        'START_DATE' => date('d-m-Y', strtotime("-1 year", time())),
        'END_DATE' => date('d-m-Y', strtotime("+1 year", time())),
        'SEARCH_HERE_FOR_A_CLIENT' => __('Search'),
        'IMAGE_DIMENSIONS_NOT_ALLOWED' => __('Allowed dimensions are width <= 380 and height <= 65')
    );
    echo $this->Html->scriptBlock('var phkondo = ' . $this->Js->object($phkondo) . ';');
    ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $("form").submit(function() {
                // prevent duplicate form submissions
                var submitBtns = $(this).find(":submit");
                console.log(submitBtns);
                submitBtns.attr('disabled', 'disabled').prepend(' <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> ');

            });
            var phkondolang = 'en-GB';
            switch (phkondo.APP_LANG) {
                case 'eng':
                    phkondolang = 'en-GB';
                    break;
                case 'por':
                    phkondolang = 'pt';
                    break;
                case 'pt-br':
                    phkondolang = 'pt-BR';
                    break;
                case 'ita':
                    phkondolang = 'it';
                    break;
                case 'spa':
                    phkondolang = 'es';
                    break;
            }
            $('.datefield').datepicker({
                format: "<?php echo Configure::read('Application.calendarDateFormat'); ?>",
                weekStart: 1,
                language: phkondolang,
                todayHighlight: true
            });
            $('.datefield').attr('autocomplete', 'off');

            $('select').select2({
                language: phkondolang,
                theme: "bootstrap"
            });
            $("li.disabled").find('a').removeAttr("href");
            $("li.disabled").find('a').removeAttr("onclick");

            // tabs keep state
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script>
    <?php
    echo $this->fetch('script');
    ?>
</body>

</html>