
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

   <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">			
                <?php 
                        $deleteDisabled='';
                        $activeDisabled='';
                        if (!$fiscalYear['FiscalYear']['deletable']) { 
                            $deleteDisabled=' disabled';
                        }
                        if ($fiscalYear['FiscalYear']['active_string']){
                            $activeDisabled=' disabled';
                        }
                                        
                            
                            ?>
                <?php echo $this->Form->postLink(__('Set as Active'), array('action' => 'active', $fiscalYear['FiscalYear']['id'],'?'=>$this->request->query), array( 'class' => 'btn '.$activeDisabled)); ?>
                <li ><?php echo $this->Html->link(__('Edit Fiscal Year'), array('action' => 'edit', $fiscalYear['FiscalYear']['id'],'?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete Fiscal Year'), array('action' => 'delete', $fiscalYear['FiscalYear']['id'],'?'=>$this->request->query), array('class' => 'btn '.$deleteDisabled,'confirm'=> __('Are you sure you want to delete # %s?' , $fiscalYear['FiscalYear']['title'] ))); ?> </li>
                <li ><?php echo $this->Html->link(__('List Fiscal Years'), array('action' => 'index','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                
            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="fiscalYears view">

            <legend><?php echo __n('Fiscal Year','Fiscal Years',1); ?></legend>

            
                <table class="table table-hover table-condensed">
                    <tbody>
                        <tr>		<td class='col-sm-2'><strong><?php echo __('Title'); ?></strong></td>
                            <td>
                                <?php echo h($fiscalYear['FiscalYear']['title']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Open Date'); ?></strong></td>
                            <td>
                                <?php echo h($fiscalYear['FiscalYear']['open_date']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Close Date'); ?></strong></td>
                            <td>
                                <?php echo h($fiscalYear['FiscalYear']['close_date']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Active'); ?></strong></td>
                            <td>
                                <?php echo h($fiscalYear['FiscalYear']['active_string']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                            <td>
                                <?php echo h($fiscalYear['FiscalYear']['modified']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                            <td>
                                <?php echo h($fiscalYear['FiscalYear']['created']); ?>
                                &nbsp;
                            </td>
                        </tr>					</tbody>
                </table><!-- /.table table-hover table-condensed -->
            

        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
