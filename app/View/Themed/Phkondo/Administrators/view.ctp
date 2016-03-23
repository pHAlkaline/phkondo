
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">
            <ul class="nav nav-pills nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Administrator'), array('action' => 'edit', $administrator['Administrator']['id'],'?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete Administrator'), array('action' => 'delete', $administrator['Administrator']['id'],'?'=>$this->request->query), array('class' => 'btn ','confirm'=> __('Are you sure you want to delete # %s?' , $administrator['Administrator']['title'] ))); ?> </li>
                <li ><?php echo $this->Html->link(__('List Administrators'), array('action' => 'index','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>


            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="administrators view">

            <legend><?php echo __n('Administrator','Administrators',1); ?></legend>

            
                <table class="table table-hover table-condensed">
                    <tbody>
                        <tr>		<td class='col-sm-2'><strong><?php echo __n('Entity','Entities',1); ?></strong></td>
                            <td>
                                <?php echo h($administrator['Entity']['name']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __n('Fiscal Year','Fiscal Years',1); ?></strong></td>
                            <td>
                                <?php echo h($administrator['FiscalYear']['title']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Title'); ?></strong></td>
                            <td>
                                <?php echo h($administrator['Administrator']['title']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Functions'); ?></strong></td>
                            <td>
                                <?php echo h($administrator['Administrator']['functions']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                            <td>
                                <?php echo h($administrator['Administrator']['modified']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                            <td>
                                <?php echo h($administrator['Administrator']['created']); ?>
                                &nbsp;
                            </td>
                        </tr>					</tbody>
                </table><!-- /.table table-hover table-condensed -->
            

        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
