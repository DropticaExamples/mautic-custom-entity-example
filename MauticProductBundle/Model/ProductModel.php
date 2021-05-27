<?php

namespace MauticPlugin\MauticProductBundle\Model;

use Mautic\CoreBundle\Model\FormModel;
use MauticPlugin\MauticProductBundle\Entity\Product;
use MauticPlugin\MauticProductBundle\Form\Type\ProductType;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class ProductModel extends FormModel
{
    public function getPermissionBase()
    {
        return 'd_product:products';
    }

    public function createForm($entity, $formFactory, $action = null, $options = [])
    {
        if (!$entity instanceof Product) {
            throw new MethodNotAllowedHttpException(['Product']);
        }

        if (!empty($action)) {
            $options['action'] = $action;
        }

        return $formFactory->create(ProductType::class, $entity, $options);
    }

    public function getRepository()
    {
        return $this->em->getRepository(Product::class);
    }

    public function getEntity($id = null): Product
    {
        if (null === $id) {
            return new Product();
        }

        return parent::getEntity($id);
    }

}