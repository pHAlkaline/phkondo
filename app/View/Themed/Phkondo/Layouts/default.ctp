<?php
$projDescription = __('pHkondo Condominium Management');
$clientDescription = __('pHkondo Condominium Management');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

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
            ?>
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet"  />
            <!-- Optional theme -->
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css" rel="stylesheet" />
            <!-- Optional icons -->
            <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" />
            <?php
            echo $this->Html->css(array('datepicker/bootstrap-datepicker3.min', 'phkondo'));
            echo $this->Html->css(array('phkondo_print'), null, array('media' => 'print'));

            echo $this->fetch('css');
            ?>
            <!-- Latest compiled and minified JavaScript -->
            <script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

            <?php
            echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.min'));
            echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.pt.min'));
            echo $this->Html->script(array('libs/datepicker/bootstrap-datepicker.en-GB.min'));
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