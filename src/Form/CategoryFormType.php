<?php
	
namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CategoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('name', TextType::class)
	    	->add('description')
	    	->add('additionalType', ChoiceType::class, array(
				'attr' => [
							'class' => 'select2'
						],
				'placeholder' => 'Select...',
				'choices'  => array(
					'Persons' => 'person',
					'Organizations' => 'organization',
					'Events' => 'event',
					'Inventory' => 'product',
					'Service' => 'service')));
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class
        ]);
    }
    
}

