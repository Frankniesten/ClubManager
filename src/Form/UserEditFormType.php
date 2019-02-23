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
			    'Administrator' => [
			    	'Administrator' => 'ROLE_ADMIN',
			    	'Gebruiker' => 'ROLE_USER'
			    ],
			    'Personen' => [
		            'View' => 'ROLE_PERSON_VIEW',
			        'Edit' => 'ROLE_PERSON_EDIT',
			        'Create'   => 'ROLE_PERSON_CREATE',
			        'Delete' => 'ROLE_PERSON_DELETE',
		        ]
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

