<?php
	
namespace App\Form;

use App\Entity\User;
use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;

class UserRoleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Dashboard' => [
                        'View' => 'ROLE_DASHBOARD_VIEW',
                    ],
                    'Relations' => [
                        'View' => 'ROLE_PERSON_VIEW',
                        'Create'   => 'ROLE_PERSON_CREATE',
                        'Edit' => 'ROLE_PERSON_EDIT',
                        'Delete' => 'ROLE_PERSON_DELETE',
                    ],
                    'Events' => [
                        'View' => 'ROLE_EVENT_VIEW',
                        'Create'   => 'ROLE_EVENT_CREATE',
                        'Edit' => 'ROLE_EVENT_EDIT',
                        'Delete' => 'ROLE_EVENT_DELETE',
                    ],
                    'Inventory' => [
                        'View' => 'ROLE_PRODUCT_VIEW',
                        'Create'   => 'ROLE_PRODUCT_CREATE',
                        'Edit' => 'ROLE_PRODUCT_EDIT',
                        'Delete' => 'ROLE_PRODUCT_DELETE',
                    ],
                    'Revenue' => [
                        'View' => 'ROLE_SERVICES_VIEW',
                        'Create'   => 'ROLE_SERVICES_CREATE',
                        'Edit' => 'ROLE_SERVICES_EDIT',
                        'Delete' => 'ROLE_SERVICES_DELETE',
                    ],
                    'Statistics' => [
                        'View' => 'ROLE_STATISTICS_VIEW',
                    ],
                    'Settings' => [
                        'View' => 'ROLE_SETTINGS_VIEW',
                        'Create'   => 'ROLE_SETTINGS_CREATE',
                        'Edit' => 'ROLE_SETTINGS_EDIT',
                        'Delete' => 'ROLE_SETTINGS_DELETE',
                    ],
                ],
                'multiple' => true,
                'attr' => [
                    'class' => 'multi-select'
                ],
            ]);
	}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'inherit_data' => true,
        ]);
    }
}

