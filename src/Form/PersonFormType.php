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
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Doctrine\ORM\EntityRepository;

class PersonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('givenName', TextType::class)
	    	->add('additionalName', TextType::class, 
	    		[
	    			'required' => false
	    		])
	    	->add('familyName', TextType::class)
	    	->add('email', EmailType::class, 
	    		[
	    			'required' => false
	    		])
	    	->add('birthDate', DateType::class, 
	    		[
	    			'required' => false, 
	    			'widget' => 'single_text', 
	    			'html5' => false, 
	    			'format' => 'dd-MM-yyyy'
	    		])
	    	->add('gender', ChoiceType::class, 
	    		[
	    			'required' => false, 
	    			'attr' => ['class' => 'select2'], 
	    			'placeholder' => 'Selecteer...', 
	    			'choices'  => array(
			        	'Male' => 'Male',
						'Female' => 'Female')
				])
			->add('telephone', TextType::class, 
				[
					'required' => false
				])
			->add('telephone_2', TextType::class, 
				[
					'required' => false
				])
			->add('streetAddress', TextType::class, 
				[
					'required' => false
				])
			->add('postalCode', TextType::class, 
				[
					'required' => false
				])
			->add('addressLocality', TextType::class, 
				[
					'required' => false
				])
			->add('addressCountry', CountryType::class,
				[
		    		'required' => false,
		    		'attr' => ['class' => 'select2'],
					'placeholder' => 'Selecteer...',
				])
			->add('alumni', CheckboxType::class, 
				[
					'required' => false, 
					'attr' => ['data-plugin' => 'switchery']
				])
			->add('category', EntityType::class,
				[
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
				    'attr' => ['class' => 'select2']
				]);
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class
        ]);
    }
}