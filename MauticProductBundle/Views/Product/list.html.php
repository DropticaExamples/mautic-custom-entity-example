<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

if ('index' == $tmpl) {
    $view->extend('MauticProductBundle:Product:index.html.php');
}

if (!isset($templateVariables)) {
    $templateVariables = [];
}

if (!isset($sessionVar)) {
    $sessionVar = 'entity';
}

if (!isset($nameAction)) {
    $nameAction = 'view';
}

if (count($items)):
    if ($items instanceof \Doctrine\ORM\Tools\Pagination\Paginator):
        $items = $items->getIterator()->getArrayCopy();
    endif;
    $firstItem = reset($items);
    ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered <?php echo $sessionVar; ?>-list">
            <thead>
            <tr>
                <?php
                if (empty($ignoreStandardColumns)):
                    echo $view->render(
                        'MauticCoreBundle:Helper:tableheader.html.php',
                        [
                            'checkall'        => 'true',
                            'actionRoute'     => $actionRoute,
                            'indexRoute'      => $indexRoute,
                            'templateButtons' => [
                                'delete' => !empty($permissions[$permissionBase.':deleteown']) || !empty($permissions[$permissionBase.':deleteown']) || !empty($permissions[$permissionBase.':delete']),
                            ],
                        ]
                    );

                    echo $view->render(
                        'MauticCoreBundle:Helper:tableheader.html.php',
                        [
                            'sessionVar' => $sessionVar,
                            'orderBy'    => $tablePrefix.'.name',
                            'text'       => 'mautic.core.name',
                            'class'      => 'col-name',
                            'default'    => true,
                        ]
                    );

                    if (method_exists($firstItem, 'getContact')):
                        echo $view->render(
                            'MauticCoreBundle:Helper:tableheader.html.php',
                            [
                                'sessionVar' => $sessionVar,
                                'orderBy'    => $tablePrefix.'.contact',
                                'text'       => 'mautic.d_product.views.product.index.col.email',
                                'class'      => 'visible-md visible-lg',
                            ]
                        );
                    endif;

                endif;

                if (isset($listHeaders)):
                    foreach ($listHeaders as $header):
                        if (!isset($header['sessionVar'])):
                            $header['sessionVar'] = $sessionVar;
                        endif;

                        echo $view->render('MauticCoreBundle:Helper:tableheader.html.php', $header);
                    endforeach;
                endif;

                if (empty($ignoreStandardColumns)):
                    echo $view->render(
                        'MauticCoreBundle:Helper:tableheader.html.php',
                        [
                            'sessionVar' => $sessionVar,
                            'orderBy'    => $tablePrefix.'.id',
                            'text'       => 'mautic.core.id',
                            'class'      => 'visible-md visible-lg col-id',
                        ]
                    );
                endif;
                ?>
                <?php echo $view['content']->getCustomContent('list.headers', $mauticTemplateVars); ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <?php if (empty($ignoreStandardColumns)): ?>
                        <td>
                            <?php
                            echo $view->render(
                                'MauticCoreBundle:Helper:list_actions.html.php',
                                [
                                    'item'            => $item,
                                    'templateButtons' => [
                                        'edit' => method_exists($item, 'getCreatedBy')
                                            ?
                                            $view['security']->hasEntityAccess(
                                                $permissions[$permissionBase.':editown'],
                                                $permissions[$permissionBase.':editother'],
                                                $item->getCreatedBy()
                                            )
                                            :
                                            $permissions[$permissionBase.':edit'],
                                        'clone'  => isset($enableCloneButton) ? $permissions[$permissionBase.':create'] : false,
                                        'delete' => method_exists($item, 'getCreatedBy')
                                            ?
                                            $view['security']->hasEntityAccess(
                                                $permissions[$permissionBase.':deleteown'],
                                                $permissions[$permissionBase.':deleteother'],
                                                $item->getCreatedBy()
                                            )
                                            :
                                            $permissions[$permissionBase.':delete'],
                                        'abtest' => isset($enableAbTestButton) ? $permissions[$permissionBase.':create'] : false,
                                    ],
                                    'actionRoute'     => $actionRoute,
                                    'indexRoute'      => $indexRoute,
                                    'translationBase' => $translationBase,
                                    'customButtons'   => isset($customButtons) ? $customButtons : [],
                                ]
                            );
                            ?>
                        </td>
                        <td>
                            <div>
                                <a data-toggle="ajax" href="<?php echo $view['router']->path(
                                    $actionRoute,
                                    ['objectId' => $item->getId(), 'objectAction' => $nameAction]
                                ); ?>">
                                    <?php echo $item->getName(); ?>
                                    <?php echo $view['content']->getCustomContent('list.name', $mauticTemplateVars); ?>
                                </a>
                            </div>
                        </td>
                        <?php if (method_exists($item, 'getContact')): ?>
                            <td class="visible-md visible-lg">
                                <?php echo $item->getContact()->getEmail(); ?>
                            </td>
                        <?php endif; ?>

                    <?php endif; ?>
                    <?php
                    if (isset($listItemTemplate)):
                        $templateVariables['item'] = $item;
                        echo $view->render($listItemTemplate, $templateVariables);
                    endif;
                    ?>
                    <?php if (empty($ignoreStandardColumns)): ?>
                        <td class="visible-md visible-lg"><?php echo $item->getId(); ?></td>
                    <?php endif; ?>
                    <?php echo $view['content']->getCustomContent('list.columns', $mauticTemplateVars); ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        <?php echo $view->render(
            'MauticCoreBundle:Helper:pagination.html.php',
            [
                'totalItems' => $totalItems,
                'page'       => $page,
                'limit'      => $limit,
                'baseUrl'    => $view['router']->path($indexRoute),
                'sessionVar' => $sessionVar,
            ]
        ); ?>
    </div>
<?php else: ?>
    <?php echo $view->render('MauticCoreBundle:Helper:noresults.html.php'); ?>
<?php endif; ?>
