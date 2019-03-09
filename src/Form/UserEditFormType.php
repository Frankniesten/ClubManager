<?php
	
namespace App\Form;

use App\Entity\User;
use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Doctrine\ORM\EntityRepository;

class UserEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {	    
	    $builder
	    
	    	->add('roles', ChoiceType::class, [
		    'choices' => [
			    'Personen' => [
		            'View' => 'ROLE_PERSON_VIEW',
		            'Create'   => 'ROLE_PERSON_CREATE',
			        'Edit' => 'ROLE_PERSON_EDIT',
			        'Delete' => 'ROLE_PERSON_DELETE',
		        ],
		        'Organisaties' => [
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
		        'Inventaris' => [
		            'View' => 'ROLE_PRODUCT_VIEW',
		            'Create'   => 'ROLE_PRODUCT_CREATE',
			        'Edit' => 'ROLE_PRODUCT_EDIT',
			        'Delete' => 'ROLE_PRODUCT_DELETE',
		        ],
		        'Producten' => [
		            'View' => 'ROLE_SERVICES_VIEW',
		            'Create'   => 'ROLE_SERVICES_CREATE',
			        'Edit' => 'ROLE_SERVICES_EDIT',
			        'Delete' => 'ROLE_SERVICES_DELETE',
		        ],
		        'Parameters' => [
		            'View' => 'ROLE_SETTINGS_VIEW',
		            'Create'   => 'ROLE_SETTINGS_CREATE',
			        'Edit' => 'ROLE_SETTINGS_EDIT',
			        'Delete' => 'ROLE_SETTINGS_DELETE',
		        ],
		        'Notities' => [
		            'View' => 'ROLE_REVIEW_VIEW',
		            'Create' => 'ROLE_REVIEW_CREATE',
			        'Edit' => 'ROLE_REVIEW_EDIT',
			        'Delete' => 'ROLE_REVIEW_DELETE',
		        ],
		        'Gebruikers' => [
		            'View' => 'ROLE_USERS_VIEW',
			        'Create / Edit' => 'ROLE_USERS_EDIT',
			        'Delete' => 'ROLE_USERS_DELETE',
		        ],
		        
		    ],
		    'label' => 'Rollen',
		    'multiple' => true,
		    'attr' => [
				'class' => 'multi-select'	
				],
			]);
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
        	->setDefaults(['data_class' => User::class]);
    }
}

