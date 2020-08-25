<ol class="breadcrumb hidden-print">

    <?php if (isset($breadcrumbs) && count($breadcrumbs)) { ?>

        <?php
        foreach ($breadcrumbs as $crumb):
            $active = $crumb['active'] ? 'active' : '';
            ?>
            <?php if (!$crumb['link']) { ?>
                <li class = "<?php echo $active; ?>"><?php echo $crumb['text'];?></li>
            <?php } else { ?>
                <li class = "<?php echo $active; ?>"><a href="<?php echo $crumb['link']; ?>"><?php echo $crumb['text']; ?></a> </li>
            <?php } ?>
        <?php endforeach; ?>
    <?php } ?>

</ol>


