
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Movement Operation'), array('action' => 'edit', $movementOperation['MovementOperation']['id']), array('class' => 'btn ')); ?> </li>
                <?php
                $deleteDisabled='';
                if (!$movementOperation['MovementOperation']['deletable']){  
                 $deleteDisabled=' disabled';
                    
                } 
                 ?>
                <li ><?php echo $this->Form->postLink(__('Delete Movement Operation'), array('action' => 'delete', $movementOperation['MovementOperation']['id']), array('class' => 'btn '.$deleteDisabled,'confirm'=> __('Are you sure you want to delete # %s?' , $movementOperation['MovementOperation']['name'] ))); ?> </li>
                
                <li ><?php echo $this->Html->link(__('New Movement Operation'), array('action' => 'add'), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Movement Operations'), array('action' => 'index'), array('class' => 'btn ')); ?> </li>
                

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="movementOperations view">

            <legend><?php echo __('Movement Operation'); ?></legend>

            
                <table class="table table-hover table-condensed">
                    <tbody>
                        <tr>		<td class='col-sm-2'><strong><?php echo __('Name'); ?></strong></td>
                            <td>
                                <?php echo h($movementOperation['MovementOperation']['name']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Active'); ?></strong></td>
                            <td>
                                <?php echo h($movementOperation['MovementOperation']['active_string']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                            <td>
                                <?php echo h($movementOperation['MovementOperation']['modified']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                            <td>
                                <?php echo h($movementOperation['MovementOperation']['created']); ?>
                                &nbsp;
                            </td>
                        </tr>					</tbody>
                </table><!-- /.table table-hover table-condensed -->
            

        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
