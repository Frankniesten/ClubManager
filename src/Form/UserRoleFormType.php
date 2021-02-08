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
                    'Persons' => [
                        'View' => 'ROLE_PERSON_VIEW',
                        'Create'   => 'ROLE_PERSON_CREATE',
                        'Edit' => 'ROLE_PERSON_EDIT',
                        'Delete' => 'ROLE_PERSON_DELETE',
                    ],
                    'Organizations' => [
                        'View' => 'ROLE_ORGANIZATION_VIEW',
                        'Create'   => 'ROLE_ORGANIZATION_CREATE',
                        'Edit' => 'ROLE_ORGANIZATION_EDIT',
                        'Delete' => 'ROLE_ORGANIZATION_DELETE',
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
                    'Services' => [
                        'View' => 'ROLE_SERVICES_VIEW',
                        'Create'   => 'ROLE_SERVICES_CREATE',
                        'Edit' => 'ROLE_SERVICES_EDIT',
                        'Delete' => 'ROLE_SERVICES_DELETE',
                    ],
                    'Settings' => [
                        'View' => 'ROLE_SETTINGS_VIEW',
                        'Create'   => 'ROLE_SETTINGS_CREATE',
                        'Edit' => 'ROLE_SETTINGS_EDIT',
                        'Delete' => 'ROLE_SETTINGS_DELETE',
                    ],
                    'Statistics' => [
                        'View' => 'ROLE_STATISTICS_VIEW',
                    ],
                    'ORDER' => [
                        'View' => 'ROLE_ORDER_VIEW',
                    ],
                    'Notes' => [
                        'View' => 'ROLE_REVIEW_VIEW',
                        'Create' => 'ROLE_REVIEW_CREATE',
                        'Edit' => 'ROLE_REVIEW_EDIT',
                        'Delete' => 'ROLE_REVIEW_DELETE',
                    ],
                    'Users' => [
                        'View' => 'ROLE_USERS_VIEW',
                        'Create' => 'ROLE_USERS_CREATE',
                        'Edit' => 'ROLE_USERS_EDIT',
                        'Delete' => 'ROLE_USERS_DELETE',
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

