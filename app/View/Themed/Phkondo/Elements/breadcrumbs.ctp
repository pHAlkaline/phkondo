<ol class="breadcrumb hidden-print">
    
     <?php if (isset($breadcrumbs) && count($breadcrumbs)) { ?>

        <?php foreach ($breadcrumbs as $crumb): ?>
            <?php if ($crumb['active']) { ?>
                <li class="active"><?php echo $crumb['text']; ?></li>
            <?php } else { ?>
                <li><a href="<?php echo $crumb['link']; ?>"><?php echo $crumb['text']; ?></a> </li>

            <?php } ?>
        <?php endforeach; ?>
    <?php } ?>

</ol>


