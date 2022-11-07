
<div class="jumbotron">
    <h1><img src="<?php echo $logo_image_src; ?>" style="height:100%;" alt="phkondo" class="img-responsive center-block" /></h1>
    <!--p><?php //echo  __('Welcome'); ?></p-->
    <?php if (Configure::read('Config.language')=='por'){ ?>
    <div class="col-lg-12 text-center">
                        <h2>Administração de Condomínios</h2>
                        <p class="lead">Nas principais características inclui a gestão de períodos contabilísticos, fracções, proprietários e representantes, orçamentos, quotas, contas bancárias e respectivos movimentos, administradores, conferência de facturas, recibos, manutenção, seguros ...</p>

                        <h2>Software Gratuito</h2>
                        <p class="lead">É uma excelente ferramenta de apoio à administração de condomínios, com uma versão gratuita em regime de <a target="_blank" href="https://www.youtube.com/watch?v=Og1WuD8vMTI&amp;t=1490">software livre </a> distribuído sobre <a target="_blank" href="http://opensource.org/licenses/GPL-2.0">liçenca GNU GPL-2.0</a>.</p>

    </div>
        <?php } else { ?>
    <div class="col-lg-12 text-center">

                        <h2>Condominium HOA Management</h2>
                        <p class="lead">Including as main features management of properties its owners and representatives, accounting periods, budgets, fees, shares, bank accounts with movements, billing, payments, receipts, maintenance, insurances ....</p>

                        <h2>Free Software</h2>
                        <p class="lead">It is an excellent tool to manage your entire condo portfolio, with a free open source version and distributed under <a target="_blank" href="http://opensource.org/licenses/GPL-2.0">license GNU GPL-2.0</a>.</p>
                      
    </div>
        <?php } ?>
    <br/>
    <p class="text-right"><a class="btn btn-primary btn-lg" href="https://github.com/pHAlkaline/phkondo/wiki/Keep-This-Tool-OpenSource" target="_blank" role="button"><?php echo  __('Contribute Here') ?></a></p>
</div>


