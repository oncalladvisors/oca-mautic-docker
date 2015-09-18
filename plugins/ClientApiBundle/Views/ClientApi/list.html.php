<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 8/31/15
 * Time: 12:52 PM
 */
$view->extend('ClientApiBundle:ClientApi:index.html.php');
?>

<?php if ($items->count()): ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" id="leadTable">
            <thead>
            <tr>
                <?php
                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'checkall' => 'true',
                    'target'   => '#clientApiTable',
                    'sessionVar' => 'lead'
                ));

                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'text'       => 'mautic.core.name',
                    'class'      => 'col-lead-name',
                    'sessionVar' => 'lead'
                ));

                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'text'       => 'description',
                    'class'      => 'col-lead-email visible-md visible-lg',
                    'sessionVar' => 'lead'
                ));

                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'text'       => 'Base Url',
                    'class'      => 'col-lead-location visible-md visible-lg',
                    'sessionVar' => 'lead'
                ));

                echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', array(
                    'text'       => 'mautic.core.id',
                    'class'      => 'col-lead-id visible-md visible-lg',
                    'sessionVar' => 'lead'
                ));
                ?>
            </tr>
            </thead>
            <tbody>
            <?php echo $view->render('ClientApiBundle:ClientApi:list_rows.html.php', array(
                'items'         => $items
            )); ?>
            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        <?php echo $view->render('MauticCoreBundle:Helper:pagination.html.php', array(
            "totalItems"      => $totalItems,
            "page"            => $page,
            "limit"           => $limit,
            "menuLinkId"      => 'client_api_index',
            "baseUrl"         => $view['router']->generate('client_api_index'),
            "tmpl"            => $indexMode,
            'sessionVar'      => 'lead'
        )); ?>
    </div>
<?php else: ?>
    <?php echo $view->render('MauticCoreBundle:Helper:noresults.html.php'); ?>
<?php endif; ?>
