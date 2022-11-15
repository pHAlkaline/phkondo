<?php ?>

<div id="page-content" class="col-sm-12 col-md-10">
    <div class="config form">

        <legend><?php echo __('General'); ?></legend>
        <section>
            <?php echo $this->Form->create(
                false,
                array('url' => array('controller' => 'system_config', 'action' => 'general')),
                ['autocomplete' => 'off'],
                array(
                    'class' => 'form-horizontal',
                    'role' => 'form',
                    'inputDefaults' => array(
                        'class' => 'form-control',
                        'label' => array('class' => 'col-sm-2 control-label'),
                        'between' => '<div class="col-sm-6">',
                        'after' => '</div>'
                    )
                )
            ); ?>

            <div role="tabpanel" class="tab-pane active" id="other" aria-labelledby="other-tab">
                <h2>&nbsp;</h2>

                <fieldset>
                <div class="form-group">
                        <?php
                        $timeZones=array_combine(array_values(timezone_identifiers_list()), array_values(timezone_identifiers_list()));
                        
                        
                        echo $this->Form->input('BootstrapApp.Config.timezone', array('type'=>'select','options'=>$timeZones,'class' => 'form-control', 'label' => __('Time Zone'), 'default' => Configure::read('Config.timezone')));
                        ?>
                    </div>
                    <p>Timezones: <a target="_blank" href="https://www.php.net/manual/en/timezones.php"><?php echo __('List Of Supported Timezones'); ?></a></p>
                    <div class="form-group">
                        <?php
                        echo $this->Form->input('BootstrapApp.Application.calendarDateFormat', array('class' => 'form-control', 'label' => __('Calendar Date Format'), 'default' => Configure::read('Application.calendarDateFormat')));
                        ?>
                    </div>
                    <hr />
                    <div class="form-group">
                        <?php
                        echo $this->Form->input('BootstrapApp.Application.currencySign', array('class' => 'form-control', 'label' => __('Currency Symbol'), 'default' => Configure::read('Application.currencySign')));
                        ?>
                    </div>
                    <hr />
                    <div class="form-group">
                        <?php
                        $fileTypes=['jpg','jpeg','png','gif','ico',
                        'mp4','m4v','mov','wmv','avi','mpg','ogv','3gp','3g2',
                        'pdf','doc','ppt','pptx','pps','ppsx','odt','xls', 'xlsx','psd',
                        'mp3','m4a','ogg','wav'];
                        $allowedFileTypes=array_combine(array_values($fileTypes), array_values($fileTypes));
                        
                        echo $this->Form->input('BootstrapApp.Attachment.attachment.extensions', array('type'=>'select','multiple'=>true,'options'=>$allowedFileTypes,'class' => 'form-control', 'label' => __('Attachment Allowed Extensions'), 'default' => Configure::read('Attachment.attachment.extensions')));
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                        echo $this->Form->input('BootstrapApp.Attachment.attachment.maxSize', array('class' => 'form-control', 'label' => __('Attachment Max Size').' ( Bytes )', 'default' => Configure::read('Attachment.attachment.maxSize')));
                        ?>
                    </div>
            </div>


            <div class="form-group">
                <?php echo $this->Form->button(__('Submit'), array('type' => 'submit', 'class' => 'btn btn-large btn-primary pull-right')); ?>&nbsp;

            </div>
            <?php echo $this->Form->end(); ?>

        </section>

    </div>
</div>