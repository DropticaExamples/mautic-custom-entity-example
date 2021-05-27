<?php

namespace MauticPlugin\MauticProductBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use Mautic\CoreBundle\Entity\FormEntity;
use Mautic\LeadBundle\Entity\Lead;

class Product extends FormEntity
{
    private $id;
    private $contact;
    private $name;

    public static function loadMetadata(ORM\ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setTable('d_product')
            ->setCustomRepositoryClass(ProductRepository::class)
            ->addId();

        $builder->addNamedField('name', Types::STRING, 'name', false);
        $builder->addContact();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Lead
     */
    public function getContact(): ?Lead
    {
        return $this->contact;
    }

    /**
     * @param Lead $contact
     */
    public function setContact(Lead $contact): void
    {
        $this->contact = $contact;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}
