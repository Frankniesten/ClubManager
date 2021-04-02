<?php
	
namespace App\Form;

use App\Entity\Organization;
use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class EmployeeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    
	    $builder
	    	->add('employee', EntityType::class, array(
					    'class' => Person::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
                                ->andWhere('u.deathDate is NULL');
					    },
					    'choice_label' => function (Person $person) { return
						    $person->getFamilyName(). ', ' .
						    $person->getGivenName(). ' ' .
						    $person->getAdditionalName();
						    
						    },
					    'required' => false,
					    'multiple' => true
					));
	
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organization::class
        ]);
    }
}


