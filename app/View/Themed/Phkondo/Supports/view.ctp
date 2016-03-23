
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Support'), array('action' => 'edit', $support['Support']['id'], '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete Support'), array('action' => 'delete', $support['Support']['id'], '?' => $this->request->query), array('class' => 'btn ', 'confirm' => __('Are you sure you want to delete # %s?', $support['Support']['subject']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Support'), array('action' => 'add', '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Supports'), array('action' => 'index', '?' => $this->request->query), array('class' => 'btn ')); ?> </li>


            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="supports view">

            <legend><?php echo __n('Support', 'Supports', 1); ?></legend>


            <table class="table table-hover table-condensed">
                <tbody>
                    <tr>
                        <td class='col-sm-2'><strong><?php echo __n('Fraction', 'Fractions', 1); ?></strong></td>
                        <td>
                            <?php echo h($support['Fraction']['description']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Client'); ?></strong></td>
                        <td>
                            <?php echo h($support['Client']['name']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Subject'); ?></strong></td>
                        <td>
                            <?php echo h($support['Support']['subject']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Description'); ?></strong></td>
                        <td>
                            <?php echo h($support['Support']['description']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Notes'); ?></strong></td>
                        <td>
                            <?php echo h($support['Support']['notes']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Category'); ?></strong></td>
                        <td>
                            <?php echo h($support['SupportCategory']['name']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Status'); ?></strong></td>
                        <td>
                            <?php echo h($support['SupportStatus']['name']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Priority'); ?></strong></td>
                        <td>
                            <?php echo h($support['SupportPriority']['name']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Assigned To'); ?></strong></td>
                        <td>
                            <?php echo h($support['AssignedUser']['name']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Modified'); ?></strong></td>
                        <td>
                            <?php echo h($support['Support']['modified']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Created'); ?></strong></td>
                        <td>
                            <?php echo h($support['Support']['created']); ?>
                            &nbsp;
                        </td>
                    </tr>
                </tbody>
            </table><!-- /.table table-hover table-condensed -->


        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
