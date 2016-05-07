
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Support Category'), array('action' => 'edit', $supportCategory['SupportCategory']['id']), array('class' => 'btn ')); ?> </li>
                <?php
                $deleteDisabled='';
                if (!$supportCategory['SupportCategory']['deletable']){  
                 $deleteDisabled=' disabled';
                    
                } 
                 ?>
                <li ><?php echo $this->Form->postLink(__('Delete Support Category'), array('action' => 'delete', $supportCategory['SupportCategory']['id']), array('class' => 'btn '.$deleteDisabled,'confirm'=> __('Are you sure you want to delete # %s?' , $supportCategory['SupportCategory']['name'] ))); ?> </li>
                
                <li ><?php echo $this->Html->link(__('New Support Category'), array('action' => 'add'), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Support Categories'), array('action' => 'index'), array('class' => 'btn ')); ?> </li>
                

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="supportCategorys view">

            <legend><?php echo __('Support Category'); ?></legend>

            
                <table class="table table-hover table-condensed">
                    <tbody>
                        <tr>		<td class='col-sm-2'><strong><?php echo __('Name'); ?></strong></td>
                            <td>
                                <?php echo h($supportCategory['SupportCategory']['name']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Active'); ?></strong></td>
                            <td>
                                <?php echo h($supportCategory['SupportCategory']['active_string']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                            <td>
                                <?php echo h($supportCategory['SupportCategory']['modified']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                            <td>
                                <?php echo h($supportCategory['SupportCategory']['created']); ?>
                                &nbsp;
                            </td>
                        </tr>					</tbody>
                </table><!-- /.table table-hover table-condensed -->
            

        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
