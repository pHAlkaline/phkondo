<?php $this->Html->css('footable/footable.bootstrap.min', false); ?>
<?php $this->Html->script('moment-with-locales', false); ?>
<?php $this->Html->script('libs/footable/footable', false); ?>
<?php $this->Html->script('footable', false); ?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-2">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Entity'), array('action' => 'edit', $entity['Entity']['id']), array('class' => 'btn ')); ?> </li>
                <?php
                $deleteDisabled = '';
                if (!$entity['Entity']['deletable']) {
                    $deleteDisabled = ' disabled';
                }
                ?>


                <li ><?php echo $this->Form->postLink(__('Delete Entity'), array('action' => 'delete', $entity['Entity']['id']), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $entity['Entity']['name']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Entity'), array('action' => 'add'), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Entities'), array('action' => 'index'), array('class' => 'btn ')); ?> </li>


            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-10">

        <div class="entities view">

            <legend><?php echo __n('Entity', 'Entities', 1); ?></legend>


            <table class="table table-hover table-condensed">
                <tbody>
                    <tr>		
                        <td class='col-sm-2'><strong><?php echo __('Name'); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['name']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Vat Number'); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['vat_number']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Representative'); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['representative']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Address'); ?></strong></td>
                        <td>
                            <?php echo nl2br(h($entity['Entity']['address'])); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __n('Contact', 'Contacts', 2); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['contacts']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Email'); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['email']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Bank'); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['bank']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Nib'); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['nib']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['modified']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['created']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Observations'); ?></strong></td>
                        <td>
                            <?php echo nl2br(h($entity['Entity']['comments'])); ?>
                            &nbsp;
                        </td>
                    </tr>
                </tbody>
            </table><!-- /.table table-hover table-condensed -->


        </div><!-- /.view -->
        <?php if (count($entity['Fraction'])): ?>
            <div class="index">

                <legend class="col-sm-12"><?php echo __n('Fraction', 'Fractions', 2); ?></legend>

                <div class="row text-center loading">
                    <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" style="font-size: 40px;"></span>
                </div>
                <div class="col-sm-12 hidden">

                    <table data-empty="<?= __('Empty'); ?>"  class="footable table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th><?php echo __n('Condo', 'Condos', 1); ?></th>
                                <th><?php echo __n('Fraction', 'Fractions', 1); ?></th>
                                <th data-breakpoints="xs"><?php echo __('Location'); ?></th>
                                <th data-breakpoints="xs"><?php echo __('Description'); ?></th>
                                <th data-breakpoints="xs"><?php echo __('Mil Rate'); ?></th>
                                <th data-breakpoints="xs"><?php echo __n('Manager', 'Managers', 1); ?></th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($entity['Fraction'] as $fraction): ?>

                                <tr>
                                    <td><?php echo $this->Html->link(h($fraction['Condo']['title']), array('controller' => 'condos', 'action' => 'view', $fraction['Condo']['id'], '?' => array('condo_id' => $fraction['Condo']['id'])), array('title' => __('Details'), 'class' => '', 'escape' => false)); ?></td>
                                    <td><?php echo $this->Html->link(h($fraction['fraction']), array('controller' => 'fractions', 'action' => 'view', $fraction['id'], '?' => array('condo_id' => $fraction['Condo']['id'])), array('title' => __('Details'), 'class' => '', 'escape' => false)); ?></td>
                                    <td><?php echo h($fraction['location']); ?>&nbsp;</td>
                                    <td><?php echo h($fraction['description']); ?>&nbsp;</td>
                                    <td><?php echo h($fraction['permillage']); ?>&nbsp;</td>
                                    <td>
                                        <?php
                                        if ($fraction['manager_id'] == 0) {
                                            echo '<span style="font-weight:bold;">' . __('All owners') . '</span>';
                                        } else {
                                            echo h($fraction['Manager']['name']);
                                        }
                                        ?>
                                    </td>


                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.index -->
        <?php endif; ?>
    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
