<div id="page-container" class="row">

    <div class="col-sm-3"></div>

    <div id="page-content" class="col-sm-6">

        <div class="users form">

            <?php echo $this->Form->create('User', array('class' => 'form-horizontal',
                'role' => 'form',
                'inputDefaults' => array(
                    'class' => 'form-control',
                    'label' => array('class' => 'col-sm-2 control-label'),
                    'between' => '<div class="col-sm-6">',
                    'after' => '</div>',
                    ))); ?>
            <fieldset>
                <h2><?php echo __('Start Session'); ?></h2>
                <?php echo $this->Form->input('id'); ?>

                <div class="form-group">
                    <?php echo $this->Form->input('username', array('class' => 'form-control')); ?>

                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('password', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('language', array('options' => Configure::read('Language.list'), 'empty' => '(choose one)')); ?>
                </div><!-- .form-group -->

            </fieldset>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?><?php echo $this->Form->end(); ?>

        </div>

    </div><!-- #page-content .col.sm-9 -->

</div><!-- #page-container .row -->
