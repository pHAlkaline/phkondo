<?php

$this->Html->script('fraction_view', false); ?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left ">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('Edit Fraction'), array('action' => 'edit', $fraction['Fraction']['id'],'?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <?php
                $deleteDisabled = '';
                if (!$fraction['Fraction']['deletable'] == true) {
                    $deleteDisabled = ' disabled';
                }
                ?>
                <li ><?php echo $this->Form->postLink(__('Delete Fraction'), array('action' => 'delete', $fraction['Fraction']['id'],'?'=>$this->request->query), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $fraction['Fraction']['description']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Fraction'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Fractions'), array('action' => 'index','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Owner', 'Owners', 2), array('controller' => 'fraction_owners', 'action' => 'index','?'=>array_merge(array('fraction_id'=>$fraction['Fraction']['id']))), array('class' => 'btn ', 'escape' => false)); ?></li>
                <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Note', 'Notes', 2), array('controller' => 'fraction_notes', 'action' => 'index','?'=>array_merge(array('fraction_id'=>$fraction['Fraction']['id']))), array('class' => 'btn ', 'escape' => false)); ?></li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Insurance', 'Insurances', 2), array('controller' => 'fraction_insurances', 'action' => 'index','?'=>array_merge(array('fraction_id'=>$fraction['Fraction']['id']))), array('class' => 'btn ', 'escape' => false)); ?></li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Attachment', 'Attachments', 2), array('plugin' => 'attachments', 'controller' => 'fraction_attachments', 'action' => 'index','?'=>array_merge(array('fraction_id'=>$fraction['Fraction']['id']))), array('class' => 'btn ', 'escape' => false)); ?> </li>
                 <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Current Account'), array('action' => 'current_account','?'=>array_merge(array('fraction_id'=>$fraction['Fraction']['id']),$this->request->query)), array('target' => '_blank', 'class' => '', 'escape' => false)); ?> </li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">
        
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                   <strong><?php echo __n('Fraction', 'Fractions', 1); ?></strong></div>
            <div class="panel-body">
                <div class="fractions view">


                    <table class="table table-hover table-condensed">
                        <tbody>
                            <tr>		<td class='col-sm-2'><strong><?php echo __n('Manager', 'Managers', 1); ?></strong></td>
                                <td>
                            <?php
                            if ($fraction['Fraction']['manager_id'] == 0) {
                                echo __('All owners');
                            } else {
                                echo h($fraction['Manager']['name']);
                            }
                            ?>
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>		<td><strong><?php echo __n('Fraction', 'Fractions', 1); ?></strong></td>
                                <td>
                            <?php echo h($fraction['Fraction']['fraction']); ?>
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>		<td><strong><?php echo __n('Fraction Type', 'Fraction Types', 1); ?></strong></td>
                                <td>
                            <?php echo h($fraction['FractionType']['name']); ?>
                                    &nbsp;
                                </td>
                            </tr>
                            <tr><td><strong><?php echo __('Floor Location'); ?></strong></td>
                                <td>
                            <?php echo h($fraction['Fraction']['floor_location']); ?>
                                    &nbsp;
                                </td>
                            </tr><tr>		<td><strong><?php echo __('Description'); ?></strong></td>
                                <td>
                            <?php echo h($fraction['Fraction']['description']); ?>
                                    &nbsp;
                                </td>
                            </tr><tr>		<td><strong><?php echo __('Mil rate'); ?></strong></td>
                                <td>
                            <?php echo h($fraction['Fraction']['mil_rate']); ?>
                                    &nbsp;
                                </td>

                            <tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                                <td>
                            <?php echo h($fraction['Fraction']['modified']); ?>
                                    &nbsp;
                                </td>
                            </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                                <td>
                            <?php echo h($fraction['Fraction']['created']); ?>
                                    &nbsp;
                                </td>
                            </tr>

                        </tbody>
                    </table><!-- /.table table-hover table-condensed -->

                </div>
            </div>
        </div><!-- /.view -->
        <div class="panel panel-default" id="CommentsPanel">
            <!-- Default panel contents -->
            <div class="panel-heading"  data-toggle="collapse" data-target="#CommentsIndex"><strong><?php echo __('Comments'); ?></strong>
                <div class="clearfix content-action-menu pull-right">
                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-down"></span> ', '#CommentsPanel', array('title' => __('View %s', __('Comments')), 'id' => 'viewCommentsBtn', 'class' => ' ', 'escape' => false)); ?>
                </div>
            </div>
            <div class="panel-body collapse" id="CommentsIndex">

                <?php echo $this->Comments->display_for($fraction); ?>

            </div>

        </div>

    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
