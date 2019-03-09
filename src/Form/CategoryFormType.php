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
	    	->add('name', TextType::class, ['label' => 'Categorie'])
	    	->add('description', TextType::class, ['label' => 'Omschrijving'])
	    	->add('additionalType', ChoiceType::class, array(
				'attr' => [
							'class' => 'select2'
						],
				'placeholder' => 'Selecteer...',
				'choices'  => array(
					'Personen' => 'person',
					'Organisaties' => 'organization',
					'Events' => 'event',
					'Inventaris' => 'product',
					'Producten' => 'service')));    
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class
        ]);
    }
    
}

