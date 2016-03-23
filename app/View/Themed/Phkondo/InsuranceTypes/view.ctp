<?php
$deleteDisabled = '';
if (!$insuranceType['InsuranceType']['deletable']) {
    $deleteDisabled = ' disabled';
}
?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('Edit Insurance Type'), array('action' => 'edit', $insuranceType['InsuranceType']['id']), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete Insurance Type'), array('action' => 'delete', $insuranceType['InsuranceType']['id']), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $insuranceType['InsuranceType']['name']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Insurance Type'), array('action' => 'add'), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Insurance Types'), array('action' => 'index'), array('class' => 'btn ')); ?> </li>


            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="entities view">

            <legend><?php echo __n('Insurance Type', 'Insurance Types', 1); ?></legend>


            <table class="table table-hover table-condensed">
                <tbody>
                    <tr>		<td class='col-sm-2'><strong><?php echo __('Name'); ?></strong></td>
                        <td>
                            <?php echo h($insuranceType['InsuranceType']['name']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>	
                        <td><strong><?php echo __('Active'); ?></strong></td>
                        <td>
                            <?php echo h($insuranceType['InsuranceType']['active_string']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                        <td>
                            <?php echo h($insuranceType['InsuranceType']['modified']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                        <td>
                            <?php echo h($insuranceType['InsuranceType']['created']); ?>
                            &nbsp;
                        </td>
                    </tr>

                </tbody>
            </table><!-- /.table table-hover table-condensed -->


        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
