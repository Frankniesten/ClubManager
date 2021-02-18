<?php

namespace App\Form;

use App\Entity\Organization;
use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;



class OrganizationsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('organizations', EntityType::class, array(
                'class' => Organization::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u');
                },
                'choice_label' => function (Organization $organisation) { return
                    $organisation->getLegalName();
                },
                'required' => false,
                'multiple' => true,
                'by_reference' => false,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Person::class]);
    }
}