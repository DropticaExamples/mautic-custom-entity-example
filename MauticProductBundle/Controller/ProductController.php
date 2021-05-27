<?php
namespace MauticPlugin\MauticProductBundle\Controller;

use Mautic\CoreBundle\Controller\AbstractStandardFormController;

class ProductController extends AbstractStandardFormController
{
    protected function getControllerBase()
    {
        return 'MauticProductBundle:Product';
    }

    protected function getModelName()
    {
        return 'd_product';
    }

    public function indexAction($page = 1)
    {
        return parent::indexStandard($page);
    }

    public function newAction()
    {
        return parent::newStandard();
    }

    public function editAction($objectId, $ignorePost = false) {
        return parent::editStandard($objectId, $ignorePost);
    }

    public function deleteAction($objectId)
    {
        return parent::deleteStandard($objectId);
    }

    public function batchDeleteAction()
    {
        return parent::batchDeleteStandard();
    }

}