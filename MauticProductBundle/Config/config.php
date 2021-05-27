<?php
return [
    'name'        => 'Product',
    'description' => 'Provides custom entity for product',
    'author'      => 'Droptica',
    'version'     => '1.0.0',
    'menu'        => [
        'main' => [
            'mautic.d_product' => [
                'route'         => 'mautic_d_product_index',
                'iconClass'     => 'fa-product-hunt',
                'priority'      => -100,
            ],
        ],
    ],
    'routes' => [
        'main' => [
            'mautic_d_product_index' => [
                'path'       => '/products/{page}',
                'controller' => 'MauticProductBundle:Product:index',
            ],
            'mautic_d_product_new' => [
                'path'       => '/products/new',
                'controller' => 'MauticProductBundle:Product:new',
            ],
            'mautic_d_product_action' => [
                'path'       => '/products/{objectAction}/{objectId}',
                'controller' => 'MauticProductBundle:Product:execute',
            ],
        ],
    ],
    'services' => [
        'models' => [
            'mautic.d_product.model.d_product' => [
                'class' => \MauticPlugin\MauticProductBundle\Model\ProductModel::class,
            ],
        ],
    ],
];