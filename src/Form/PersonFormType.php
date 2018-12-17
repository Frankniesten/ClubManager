<?php
	
namespace App\Form;

use App\Entity\Person;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;

class PersonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('givenName', TextType::class, ['label' => 'Voornaam', 'required' => false])
	    	->add('additionalName', TextType::class, ['label' => 'Tussenvoegsel', 'required' => false])
	    	->add('familyName', TextType::class, ['label' => 'Achternaam', 'required' => true])
	    	->add('email', EmailType::class, ['label' => 'Email', 'required' => false])
	    	->add('birthDate', DateType::class, ['label' => 'Geboorte Datum', 'required' => false])
	    	->add('gender', ChoiceType::class, [
	    		'label' => 'Geslacht', 
	    		'required' => false,
	    		 'choices'  => array(
			        'Man' => 'Man',
			        'Vrouw' => 'Vrouw')])
			->add('telephone', TextType::class, ['label' => 'Telefoon', 'required' => false])
			->add('telephone_2', TextType::class, ['label' => 'Mobiel', 'required' => false])
			
			->add('streetAddress', TextType::class, ['label' => 'Straat', 'required' => false])
			->add('postalCode', TextType::class, ['label' => 'Postcode', 'required' => false])
			->add('addressLocality', TextType::class, ['label' => 'Woonplaats', 'required' => false])
			->add('addressCountry', ChoiceType::class, [
	    		'label' => 'Land', 
	    		'required' => false,
	    		 'choices'  => array(
			        'Nederland' => 'Nederland',
			        'België' => 'België',
			        'Duitsland' => 'Duitsland')])
			
			->add('categorie', EntityType::class, array(
					    'class' => Categorie::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
					        	->andWhere('u.additionalType = :additionalType')
					        	->setParameter('additionalType', 'personen')
					            ->orderBy('u.name', 'ASC');
					    },
					    'choice_label' => 'name',
					    'required' => true
					));
	
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class
        ]);
    }
}

