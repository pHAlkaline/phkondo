<?php
/**
  CakePHP Feedback Plugin

  Copyright (C) 2012-3827 dr. Hannibal Lecter / lecterror
  <http://lecterror.com/>

  Multi-licensed under:
  MPL <http://www.mozilla.org/MPL/MPL-1.1.html>
  LGPL <http://www.gnu.org/licenses/lgpl.html>
  GPL <http://www.gnu.org/licenses/gpl.html>
 */
?>


<div class="form">

    <?php
    echo $this->Form->create('Feedback.Comment', array
        (
        'class' => 'form-horizontal',
        'role' => 'form',
        'inputDefaults' => array(
            'class' => 'form-control',
            'label' => array('class' => 'col-sm-2 control-label'),
            'between' => '<div class="col-sm-6">',
            'after' => '</div>',
        ),
        'url' => array
            (
            'plugin' => 'feedback',
            'controller' => 'comments',
            'action' => 'add',
            $foreign_model,
            $foreign_id
        )
            )
    );
    ?>



    <fieldset>
        <?php
        echo $this->Form->input('Comment.author_name', array('type' => 'hidden', 'value' => AuthComponent::user('name')));
        echo $this->Form->input('Comment.author_email', array('type' => 'hidden', 'value' => 'user@phkondo.net'));
        echo $this->Form->input('Comment.author_website', array('type' => 'hidden', 'value' => 'http://phkondo.net'));
        echo $this->Form->input('Comment.remember_info', array('type' => 'hidden', 'value' => true));
        echo $this->Form->input('Comment.hairy_pot', array('type' => 'hidden'));
        echo $this->Form->input('Comment.foreign_model', array('type' => 'hidden', 'value' => $foreign_model));
        echo $this->Form->input('Comment.foreign_id', array('type' => 'hidden', 'value' => $foreign_id));
        ?>
        <h2><?php echo __('Add Comment'); ?></h2>
        <div class="form-group">
            <?php echo $this->Form->input('Comment.content', array('class' => 'form-control')); ?>
        </div><!-- .form-group -->


    </fieldset>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-6">
            <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>

</div><!-- /.form -->
