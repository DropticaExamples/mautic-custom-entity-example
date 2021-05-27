<?php
namespace MauticPlugin\MauticProductBundle\Form\Type;

use Mautic\CoreBundle\Form\Type\FormButtonsType;
use Mautic\LeadBundle\Entity\Lead;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label'             => 'mautic.d_product.form.type.name',
                'label_attr'        => ['class' => 'control-label'],
                'attr'              => [
                    'class' => 'form-control',
                ],
                'required' => true,
            ]
        );

        $builder->add(
            'contact',
            EntityType::class,
            [
                'class' => Lead::class,
                'choice_label' => 'email',
                'label' => 'mautic.d_product.form.type.contact',
                'attr' => [
                    'class' => 'form-control',
                ]
            ]
        );

        $builder->add(
            'buttons',
            FormButtonsType::class,
            [
                'apply_text' => false,
                'save_text' => 'mautic.core.form.save',
            ]
        );
    }

}