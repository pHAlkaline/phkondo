<h1>
    <?php echo $header_title ?>
    <small><?php echo $header_subtitle; ?></small>
</h1>
<ol class="breadcrumb hidden-print">

    <?php if (count($breadcrumbs)) { ?>

        <?php foreach ($breadcrumbs as $crumb): ?>
            <?php 
            if (isset($crumb['icon_class'])){ 
                $crumb_icon = '<i class="'.$crumb['icon_class'].'"></i>';
            } 
            ?>
            <?php if ($crumb['active']) { ?>
                <li class="active"><?php echo $crumb['text']; ?></li>
                <?php } else { ?>
                <li><a href="<?php echo $crumb['link']; ?>"><?php echo $crumb['text']; ?></a> </li>

            <?php } ?>
        <?php endforeach; ?>
    <?php } ?>

</ol>
