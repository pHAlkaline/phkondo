<?php $this->Html->css('footable/footable.bootstrap.min', false); ?>
<?php $this->Html->script('moment-with-locales', false); ?>
<?php $this->Html->script('libs/footable/footable', false); ?>
<?php $this->Html->script('footable', false); ?>
<div id="page-container" class="row">

    <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-sm-9"><?php echo __('Insurance Types'); ?></h2>
            <div class="actions hidden-print col-sm-3">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> ' . __('New Insurance Type'), array('action' => 'add'), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 0; float: right;', 'escape' => false));
                ?>
            </div><!-- /.actions -->

        <?php echo $this->element('search_tool'); ?>
            <div class="row text-center loading">
                <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" style="font-size: 40px;"></span>
            </div>
            <div class="col-sm-12 hidden">

                <table data-empty="<?= __('Empty'); ?>"  class="footable table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('name'); ?></th>
                            <th><?php echo $this->Paginator->sort('active'); ?></th>
                            <th  data-breakpoints="xs" class="actions hidden-print"><?php //echo __('Actions');     ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($insuranceTypes as $insuranceType): ?>
                        <tr>
                            <td><?php echo h($insuranceType['InsuranceType']['name']); ?>&nbsp;</td>
                            <td><?php echo h($insuranceType['InsuranceType']['active_string']); ?>&nbsp;</td>
                            <td data-breakpoints="xs" class="actions hidden-print">
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $insuranceType['InsuranceType']['id']), array('title' => __('Details'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $insuranceType['InsuranceType']['id']), array('title' => __('Edit'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                <?php
                                $deleteDisabled = '';
                                if (!$insuranceType['InsuranceType']['deletable']) {
                                    $deleteDisabled = ' disabled';
                                }
                                ?>
                                <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $insuranceType['InsuranceType']['id']), array('title' => __('Remove'), 'class' => 'btn btn-default btn-xs ' . $deleteDisabled, 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $insuranceType['InsuranceType']['name']))); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->

            <p class='pull-right'><small>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>                </small></p>
            <div class="clearfix"></div>
            <ul class="hidden-print pagination pull-right">
    <?php
    echo $this->Paginator->prev('< ' . __('Previous'), array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
    echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'tag' => 'li', 'currentClass' => 'disabled'));
    echo $this->Paginator->next(__('Next') . ' >', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
    ?>
            </ul><!-- /.pagination -->
        </div><!-- /.actions -->
    </div><!-- /.box-body -->

</div>
