
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('View %s', __n('Fraction', 'Fractions', 1)), array('action' => 'view', $this->Form->value('Fraction.id'),'?'=>$this->request->query), array('class' => 'btn')); ?></li>
                <?php
                $deleteDisabled = '';
                if (!$this->Form->value('Fraction.deletable')) {
                    $deleteDisabled = ' disabled';
                }
                ?>
                <li ><?php echo $this->Form->postLink(__('Delete Fraction'), array('action' => 'delete', $this->Form->value('Fraction.id'),'?'=>$this->request->query), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Fraction.description')))); ?></li>
                <li ><?php echo $this->Html->link(__('List Fractions'), array('action' => 'index','?'=>$this->request->query), array('class' => 'btn')); ?></li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="fractions form">

            <?php
            echo $this->Form->create('Fraction', array(
                'class' => 'form-horizontal',
                'role' => 'form',
                'inputDefaults' => array(
                    'class' => 'form-control',
                    'label' => array('class' => 'col-sm-2 control-label'),
                    'between' => '<div class="col-sm-6">',
                    'after' => '</div>')
            ));
            ?>
            <fieldset>
                <legend><?php echo __('Edit Fraction'); ?></legend>
                <?php echo $this->Form->input('id'); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('condo_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('manager_id', array('empty' => __('All owners'), 'class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('fraction', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group ">
                    <?php echo $this->Form->input('fraction_type_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('floor_location', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('description', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('mil_rate', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

            </fieldset>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
