<?php
	
namespace App\Form;

use App\Entity\Service;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ServiceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('serviceType', TextType::class, ['required' => true])
	    	->add('description', TextType::class, ['required' => false])
	    	->add('availableChannel', ChoiceType::class, [
	    		'required' => false,
	    		'placeholder' => 'Select...',
	    		'attr' => [
							'class' => 'select2'
						],
	    		 'choices'  => array(
			        'Regular' => 'Regular',
			        'Webshop' => 'Webshop')])
			->add('category', EntityType::class, array(
					    'class' => Category::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
					        	->andWhere('u.additionalType = :additionalType')
					        	->setParameter('additionalType', 'service')
					            ->orderBy('u.name', 'ASC');
					    },
					    'choice_label' => 'name',
					    'required' => true,
					    'placeholder' => 'Select...',
					    'attr' => [
							'class' => 'select2'
						]
					)); 
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class
        ]);
    }
}