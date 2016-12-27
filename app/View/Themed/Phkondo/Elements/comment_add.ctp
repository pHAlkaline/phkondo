
<div class="box-footer">
    <?php
    echo $this->Form->create('Feedback.Comment', array
        (
        'class' => 'form-horizontal',
        'role' => 'form',
        'inputDefaults' => array(
            'class' => null,
            'label' => null,
            'between' => null,
            'after' => null,
        ),
        'url' => array
            (
            'controller' => 'comments',
            'action' => 'add',
            $foreign_model,
            $foreign_id
        )
            )
    );
    ?>
    <?php
    echo $this->Form->input('Comment.author_name', array('type' => 'hidden', 'value' => AuthComponent::user('name')));
    echo $this->Form->input('Comment.author_email', array('type' => 'hidden', 'value' => 'user@user.net'));
    echo $this->Form->input('Comment.author_website', array('type' => 'hidden', 'value' => 'http://user.net'));
    echo $this->Form->input('Comment.remember_info', array('type' => 'hidden', 'value' => true));
    echo $this->Form->input('Comment.hairy_pot', array('type' => 'hidden'));
    echo $this->Form->input('Comment.foreign_model', array('type' => 'hidden', 'value' => $foreign_model));
    echo $this->Form->input('Comment.foreign_id', array('type' => 'hidden', 'value' => $foreign_id));
    ?>
    <div class="img-push">
        <?php echo $this->Form->input('Comment.content', array('label'=>false,'type'=>'text','placeholder' => __('Write and Press enter to post comment.'), 'class' => 'form-control input-sm')); ?>

    </div>
    <?php //echo $this->Html->image('avatar5.png', array('class'=>'img-circle img-sm','alt' => AuthComponent::user('username'))); ?>
        <!-- .img-push is used to add margin to elements next to floating images -->
    
    <?php echo $this->Form->end(); ?>
</div>
