<?php
	
namespace App\Form;

use App\Entity\Person;
use App\Entity\Category;
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

class PersonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('givenName', TextType::class, ['label' => 'Voornaam'])
	    	->add('additionalName', TextType::class, ['label' => 'Tussenvoegsel', 'required' => false])
	    	->add('familyName', TextType::class, ['label' => 'Achternaam'])
	    	->add('email', EmailType::class, ['label' => 'Email', 'required' => false])
	    	->add('birthDate', DateType::class, ['label' => 'Geboorte Datum', 'required' => false, 'widget' => 'single_text', 'html5' => false,])
	    	->add('gender', ChoiceType::class, [
	    		'label' => 'Geslacht', 
	    		'required' => false,
	    		'attr' => [
							'class' => 'select2'
						],
				 'placeholder' => 'Selecteer...',
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
	    		'attr' => [
							'class' => 'select2'
						],
				 'placeholder' => 'Selecteer...',
	    		 'choices'  => array(
			        'Nederland' => 'Nederland',
			        'België' => 'België',
			        'Duitsland' => 'Duitsland')])
			->add('alumni', CheckboxType::class, ['label' => 'Persoon is alumni van de vereniging (oud lid)', 'required' => false, 'attr' => ['data-plugin' => 'switchery']])
			->add('category', EntityType::class, array(
					    'class' => Category::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
					        	->andWhere('u.additionalType = :additionalType')
					        	->setParameter('additionalType', 'person')
					            ->orderBy('u.name', 'ASC');
					    },
					    'placeholder' => 'Selecteer...',
					    'choice_label' => 'name',
					    'required' => true,
					    'attr' => [
							'class' => 'select2'
						]
					));
	
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class
        ]);
    }
}

