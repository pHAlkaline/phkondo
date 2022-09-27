<?php

$this->Html->css('footable/footable.bootstrap.min', false); ?>
<?php $this->Html->script('moment-with-locales', false); ?>
<?php $this->Html->script('libs/footable/footable', false); ?>
<?php $this->Html->script('footable', false); ?>
<div id="page-container" class="row">

    <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-sm-9"><?php echo __n('Fraction', 'Fractions', 2); ?></h2>

            <div class="actions hidden-print col-sm-3">
                <?php
                echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> ' . __('New Fraction'), array('action' => 'add', '?' => $this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 0; float:right', 'escape' => false));
                ?> 
            </div><!-- /.actions -->
            <?php echo $this->element('search_tool'); ?>
            <div class="clearfix"></div>
            <?php
            if ($milRateWarning):
                ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo __('Warning: permillage sum should be 1000'); ?></div>

            <?php endif; ?>
            <div class="row text-center loading">
                <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" style="font-size: 40px;"></span>
            </div>
            <div class="col-sm-12 hidden">

                <table data-empty="<?= __('Empty'); ?>"  class="footable table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('fraction'); ?></th>
                            <th><?php echo $this->Paginator->sort('location'); ?></th>
                            <th data-breakpoints="xs" ><?php echo $this->Paginator->sort('description'); ?></th>
                            <th data-breakpoints="xs" ><?php echo $this->Paginator->sort('permillage'); ?></th>
                            <th><?php echo $this->Paginator->sort('Manager.name', __n('Manager', 'Managers', 1)); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('FractionType.name', __('Fraction Type')); ?></th>
                            <th data-breakpoints="xs" class="text-right"><?php echo __('Current Account'); ?></th>
                            <th class="actions hidden-print" data-breakpoints="xs"><?php //echo __('Actions');            ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fractions as $index => $fraction): ?>
                        <tr <?= $index == 0 ? 'data-expanded="true"' : ''; ?> >
                            <td><?php echo h($fraction['Fraction']['fraction']); ?>&nbsp;</td>
                            <td><?php echo h($fraction['Fraction']['location']); ?>&nbsp;</td>
                            <td><?php echo h($fraction['Fraction']['description']); ?>&nbsp;</td>
                            <td><?php echo h($fraction['Fraction']['permillage']); ?>&nbsp;</td>
                            <td><?php
                                    if ($fraction['Fraction']['manager_id'] == 0) {
                                        foreach ($fraction['Entity'] as $manager) {
                                            echo h($manager['name']) . "<br/>";
                                        }
                                    } else {
                                        echo h($fraction['Manager']['name']);
                                    }
                                 ?>
                            </td>
                            <td><?php echo h($fraction['Fraction']['permillage']); ?>&nbsp;</td>
                            <td class="text-right"><?php echo number_format($fraction['Fraction']['current_account'], 2); ?>&nbsp;<?php echo Configure::read('Application.currencySign'); ?></td>
                            <td class="actions hidden-print">
                                    <?php  $deleteDisabled = '';
                                    if (!$fraction['Fraction']['deletable'] == true) {
                                        $deleteDisabled = ' disabled';
                                    }
                                    echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $fraction['Fraction']['id'], '?' => $this->request->query), array('title' => __('Details'), 'class' => 'btn btn-default btn-xs', 'escape' => false));
                                    echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $fraction['Fraction']['id'], '?' => $this->request->query), array('title' => __('Edit'), 'class' => 'btn btn-default btn-xs', 'escape' => false));
                                    echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $fraction['Fraction']['id'], '?' => $this->request->query), array('title' => __('Remove'), 'class' => 'btn btn-default btn-xs' . $deleteDisabled, 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $fraction['Fraction']['fraction']))); 
                                    ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <p class='pull-right'><small>
                    <?php
                    echo $this->Paginator->counter(array(
                        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                    ));
                    ?>                </small></p>

            <div class='clearfix'></div><ul class="hidden-print pagination pull-right">
                <?php
                echo $this->Paginator->prev('< ' . __('Previous'), array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
                echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'tag' => 'li', 'currentClass' => 'disabled'));
                echo $this->Paginator->next(__('Next') . ' >', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
                ?>
            </ul><!-- /.pagination -->

        </div><!-- /.index -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
