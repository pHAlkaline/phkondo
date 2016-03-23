<?php

$roles=Configure::read('User.role'); ?>

<div id="page-container" class="row row-offcanvas row-offcanvas-left">
    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">
            <ul class="nav nav-pills nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id']), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn ','confirm'=> __('Are you sure you want to delete # %s?' , $user['User']['name'] ))); ?> </li>
                <li ><?php echo $this->Html->link(__('New User'), array('action' => 'add'), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Users'), array('action' => 'index'), array('class' => 'btn ')); ?> </li>


            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="users view">

            <legend><?php echo __('User'); ?></legend>


            <table class="table table-hover table-condensed">
                <tbody>
                    <tr>		<td class='col-sm-2'><strong><?php echo __('Name'); ?></strong></td>
                        <td>
                                <?php echo h($user['User']['name']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Username'); ?></strong></td>
                        <td>
                                <?php echo h($user['User']['username']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Role'); ?></strong></td>
                        <td>
                                <?php echo h(__($roles[$user['User']['role']])); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Active'); ?></strong></td>
                        <td>
                                <?php echo h($user['User']['active_string']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                        <td>
                                <?php echo h($user['User']['modified']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                        <td>
                                <?php echo h($user['User']['created']); ?>
                            &nbsp;
                        </td>
                    </tr>					</tbody>
            </table><!-- /.table table-hover table-condensed -->


        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
