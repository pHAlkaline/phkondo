
<div id="page-container" class="row">
    <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-sm-9"><?php echo __('Income Control'); ?>&nbsp;</h2>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo __('Title'); ?></th>
                            <th class="actions hidden-print"><?php //echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo __n('Receipt','Receipts',2); ?>&nbsp;</td>
                            <td class="actions hidden-print">
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-list-alt"></span> ', array('action' => 'receipts'), array('title'=>__n('Receipt','Receipts',2),'class' => 'btn btn-default btn-xs', 'escape' => false)); ?> 

                            </td>
                        </tr>
                       

                    </tbody>
                </table>
            </div>
            <h2 class="col-sm-9">&nbsp;</h2>
            <h2 class="col-sm-9">&nbsp;</h2>
        </div><!-- /.index -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
