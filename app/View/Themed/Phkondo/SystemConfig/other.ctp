<?php ?>

<div id="page-content" class="col-sm-10">
    <div class="install form">

        <legend><?php echo __('Other'); ?></legend>
        <section>
              <?php echo $this->Form->create(false, 
                      array('url' => array('controller' => 'system_config', 'action' => 'other')),
                      ['autocomplete'=>'off'],
                      array(
                'class' => 'form-horizontal',
                'role' => 'form',
                'inputDefaults' => array(
                    'class' => 'form-control',
                    'label' => array('class' => 'col-sm-2 control-label'),
                    'between' => '<div class="col-sm-6">',
                    'after' => '</div>'))); ?>

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#application" aria-controls="application" role="tab" data-toggle="tab"><?= __('Application'); ?></a>

                </li>
                <li role="presentation" >
                    <a href="#attachment" aria-controls="attachment" role="tab" data-toggle="tab"><?= __('Attachment'); ?></a>

                </li>
                <li role="presentation" >
                    <a href="#pdfengine" aria-controls="pdfengine" role="tab" data-toggle="tab"><?= __('PDF Engine'); ?></a>

                </li>

                <li role="presentation" >
                    <a href="#timezone" aria-controls="timezone" role="tab" data-toggle="tab"><?= __('TimeZone'); ?></a>

                </li>


            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="other" aria-labelledby="other-tab">
                    <h2>&nbsp;</h2>

                    <fieldset>

                        <div class="form-group">
                <?php
                echo $this->Form->input('Application.currencySign', array('class' => 'form-control', 'label' => __('Currency Sign'), 'default' => Configure::read('Application.currencySign')));
                ?>
                        </div>

                        <div class="form-group">
                <?php
                echo $this->Form->input('Application.calendarDateFormat', array('class' => 'form-control', 'label' => __('Calendar Date Format'), 'default' => Configure::read('Application.calendarDateFormat')));
                ?>
                        </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="attachment" aria-labelledby="attachment-tab">
                    <h2>&nbsp;</h2>

                    <fieldset>

                        <div class="form-group">
                <?php
                echo $this->Form->input('Application.currencySign', array('class' => 'form-control', 'label' => __('Currency Sign'), 'default' => Configure::read('Application.currencySign')));
                ?>
                        </div>

                        <div class="form-group">
                <?php
                echo $this->Form->input('Application.calendarDateFormat', array('class' => 'form-control', 'label' => __('Calendar Date Format'), 'default' => Configure::read('Application.calendarDateFormat')));
                ?>
                        </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="pdfengine" aria-labelledby="pdfengine-tab">
                    <h2>&nbsp;</h2>

                    <fieldset>

                        <div class="form-group">
                <?php
                echo $this->Form->input('Application.currencySign', array('class' => 'form-control', 'label' => __('Currency Sign'), 'default' => Configure::read('Application.currencySign')));
                ?>
                        </div>

                        <div class="form-group">
                <?php
                echo $this->Form->input('Application.calendarDateFormat', array('class' => 'form-control', 'label' => __('Calendar Date Format'), 'default' => Configure::read('Application.calendarDateFormat')));
                ?>
                        </div>
                </div>
                <div role="tabpanel" class="tab-pane " id="timezone" aria-labelledby="timezone-tab">
                    <h2>&nbsp;</h2>

                    <p>Timezones: <a target="_blank" href="https://www.php.net/manual/en/timezones.php"><?php echo __('List Of Supported Timezones'); ?></a></p>
                    <div class="form-group">
                <?php
                echo $this->Form->input('Config.timezone', array('class' => 'form-control', 'label' => __('pHKondo Timezone'), 'default' => Configure::read('Config.timezone')));
                ?>
                    </div>

                </div>
            </div>
            <div class="form-group">
            <?php echo $this->Form->button(__('Submit'), array('type'=>'submit','class' => 'btn btn-large btn-primary pull-right')); ?>&nbsp;  

            </div>
        <?php echo $this->Form->end(); ?>

        </section>

    </div>
</div>