<?php
$projDescription = __('pHkondo Condominium Management');
$clientDescription = __('pHkondo Condominium Management');
?>
<!DOCTYPE html>
<html >

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $clientDescription ?>:
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->fetch('meta');
        echo $this->Html->css(array('bootstrap/bootstrap-glyphicons', 'bootstrap/font-awesome.min', 'bootstrap/bootstrap', 'bootstrap/bootstrap-theme', 'datepicker/bootstrap-datepicker3.min', 'phkondo'));
        echo $this->Html->css(array('phkondo_print'), null, array('media' => 'print'));

        echo $this->fetch('css');
        ?>
        <?php
        echo $this->Html->script(array('libs/jquery-2.1.3.min', 'libs/bootstrap.min'));
        echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.min'));
        echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.pt.min'));
        echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.en-GB.min'));
        $phkondo = array(
            'APP_PATH' => Router::url('/', true),
            'APP_LANG' => Configure::read('Config.language'),
            'START_DATE' => date('d-m-Y', strtotime("-1 year", time())),
            'END_DATE' => date('d-m-Y', strtotime("+1 year", time()))
        );
        echo $this->Html->scriptBlock('var phkondo = ' . $this->Js->object($phkondo) . ';');
        echo $this->fetch('script');
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.datefield').datepicker({
                    format: "<?= Configure::read('calendarDateFormat'); ?>",
                    weekStart: 1,
                    language: "pt",
                    todayHighlight: true
                });

            });
        </script>
    </head>

    <body>

        <div id="main-container">

            <div id="header" class="container hidden-print">
                <?php echo $this->element('menu/top_menu', array('headerDescription' => $clientDescription)); ?>
            </div><!-- #header .container -->

            <div id="content" class="container">
                <div class="no-print">
                    <?php if (isset($breadcrumbs)) echo $this->element('breadcrumbs', array('breadcrumbs', $breadcrumbs)); ?>
                    <?php echo $this->Session->flash(); ?>
                </div>
                <?php echo $this->fetch('content'); ?>
            </div><!-- #header .container -->

            <div id="footer" class="container hidden-print">
                <div style="text-align: center;">Copyright (c) pHAlkaline (<a href="http://phalkaline.eu" target="_blank">http://phalkaline.eu</a>)</div>
                <?php //Silence is golden   ?>
            </div><!-- #footer .container -->

        </div><!-- #main-container -->

        <!--div class="container">
                <div class="well">
                        <small>
        <?php //echo $this->element('sql_dump');   ?>
                        </small>
                </div>
        </div><!-- .container -->

    </body>

</html>