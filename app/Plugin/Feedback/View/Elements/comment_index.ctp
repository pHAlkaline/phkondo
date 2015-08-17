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
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3><?php __('Comments'); ?></h3>
        </div><!-- /col-sm-12 -->
    </div><!-- /row -->
    <?php foreach ($comments as $comment): ?>
        <?php
        // permalink
        $timestamp = $this->Comments->Time->timeAgoInWords($comment['created'], array('format' => 'Y/m/d H:i'));
        $timestamp = $comment['created'];
        $permalink = $this->Html->link($timestamp, '#comment-' . $comment['id'], array('title' => __('Permalink')));
        ?>
        <div class="row col-sm-9">
            <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?php echo Sanitize::html($comment['author_name']); ?></strong> 
                        <span class="text-muted pull-right">
                            <?php echo $timestamp; ?>
                            
                        </span>
                        
                    </div>
                    <div class="panel-body">
                        <?php if ($comment['user_id'] == AuthComponent::user('id') || AuthComponent::user('role')=='admin' ): ?>
                            <?php echo $this->Form->postlink('<span class="glyphicon glyphicon-remove"></span> ', array('plugin' => 'feedback', 'controller' => 'comments', 'action' => 'delete', $comment['id']), array('title' => __('Delete'), 'class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin-left:10px;', 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', substr($comment['content'], 0, 15).'...'))); ?>
                        <?php endif; ?>
                        <?php echo nl2br(Sanitize::html($comment['content'])); ?>
                        
                    </div><!-- /panel-body -->
                </div><!-- /panel panel-default -->
            </div><!-- /row -->
    <?php endforeach; ?>

</div><!-- /container -->

