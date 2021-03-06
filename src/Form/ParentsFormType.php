<?php
	
namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ParentsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	   	$this->personId = $options['personId'];
	    
	    $builder
	    	->add('parents', EntityType::class, array(
					    'class' => Person::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
					        ->where('u.id != :selfId')
                            ->andWhere('u.deathDate is NULL')
					        ->orderBy('u.familyName', 'ASC')
					        ->setParameter('selfId', $this->personId);
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
        $resolver
        	->setDefaults(['data_class' => Person::class])
        	->setRequired('personId')
			->setAllowedTypes('personId', array('string'));
    }
}


