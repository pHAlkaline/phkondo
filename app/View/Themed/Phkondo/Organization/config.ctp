<?php $this->Html->script('organization_config', false); ?>
<div id="page-content" class="col-sm-10">
    <div class="form">
        <section>
              <?php echo $this->Form->create(false,array(
                'type' => 'file',
                'class' => 'form-horizontal',
                'role' => 'form',
                'inputDefaults' => array(
                    'class' => 'form-control',
                    'label' => array('class' => 'col-sm-2 control-label'),
                    'between' => '<div class="col-sm-6">',
                    'after' => '</div>')
            )); ?>

            <fieldset>
                <legend><?php echo __('Edit Organization'); ?></legend>
                <div class="form-group">
                    <?php echo $this->Form->input('name', array('default' => $organization['name'], 'class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('vat_number', array('default' => $organization['vat_number'], 'class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('representative', array('default' => $organization['representative'], 'class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('address', array('default' => $organization['address'], 'class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('contact', array('default' => $organization['contact'], 'class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('email', array('default' => $organization['email'], 'class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('logo', array('label' => array('text'=>'Logo (Max:380x65)','class' => 'col-sm-2 control-label'),'type' => 'file', 'class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <h1 class=""><img src="<?php echo $logo_image_src; ?>" style="height:100%;" alt="phkondo" class="logoimg img-responsive center-block" /></h1>

            </fieldset>

            <div class="form-group">                
            <?php echo $this->Form->button(__('Submit'), array('type'=>'submit','class' => 'btn btn-large btn-primary pull-right')); ?>&nbsp;  

            </div>
        <?php echo $this->Form->end(); ?>

        </section>

    </div>
</div>