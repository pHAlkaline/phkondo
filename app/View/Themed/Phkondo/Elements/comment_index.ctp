<div class="box-footer box-comments">
    <?php foreach ($comments as $comment): ?>
        <?php
        // permalink
        $timestamp = $this->Comments->Time->timeAgoInWords($comment['created'], array('format' => 'Y/m/d H:i'));
        $timestamp = $comment['created'];
        $permalink = $this->Html->link($timestamp, '#comment-' . $comment['id'], array('title' => __('Permalink')));
        ?>
        <div class="box-comment">
            <!-- User image -->
            <?php echo $this->Html->image('avatar5.png', array('class' => 'img-circle img-sm', 'alt' => AuthComponent::user('username'))); ?>
            <div class="comment-text">
                <span class="username">
                    <?php echo Sanitize::html($comment['author_name']); ?>


                    <span class="text-muted pull-right">
                        <?php echo $timestamp; ?>
                        <?php if ($comment['user_id'] == AuthComponent::user('id') || AuthComponent::user('role') == 'admin'): ?>
                            <?php echo $this->Form->postlink('<button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span></button> ', array('controller' => 'comments', 'action' => 'delete', $comment['id']), array('title' => __('Delete'), 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', nl2br(Sanitize::html(substr($comment['content'], 0, 20) . '...'))))); ?>
                        <?php endif; ?>
                    </span>

                </span><!-- /.username -->
                <?php echo nl2br(Sanitize::html($comment['content'])); ?>
            </div><!-- /.comment-text -->

        </div><!-- /.box-comment -->
    <?php endforeach; ?>
</div>
