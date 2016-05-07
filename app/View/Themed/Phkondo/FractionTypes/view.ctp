<?php
$deleteDisabled = '';
if (!$fractionType['FractionType']['deletable']) {
    $deleteDisabled = ' disabled';
}
?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('Edit Fraction Type'), array('action' => 'edit', $fractionType['FractionType']['id']), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete Fraction Type'), array('action' => 'delete', $fractionType['FractionType']['id']), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $fractionType['FractionType']['name']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Fraction Type'), array('action' => 'add'), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Fraction Types'), array('action' => 'index'), array('class' => 'btn ')); ?> </li>


            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="entities view">

            <legend><?php echo __n('Fraction Type', 'Fraction Types', 1); ?></legend>


            <table class="table table-hover table-condensed">
                <tbody>
                    <tr>		<td class='col-sm-2'><strong><?php echo __('Name'); ?></strong></td>
                        <td>
                            <?php echo h($fractionType['FractionType']['name']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>	
                        <td><strong><?php echo __('Active'); ?></strong></td>
                        <td>
                            <?php echo h($fractionType['FractionType']['active_string']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                        <td>
                            <?php echo h($fractionType['FractionType']['modified']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                        <td>
                            <?php echo h($fractionType['FractionType']['created']); ?>
                            &nbsp;
                        </td>
                    </tr>

                </tbody>
            </table><!-- /.table table-hover table-condensed -->


        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
