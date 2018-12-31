<?php
	
namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CategorieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('name', TextType::class, ['label' => 'Categorie'])
	    	->add('description', TextType::class, ['label' => 'Omschrijving'])
	    	->add('additionalType', ChoiceType::class, array(
				'choices'  => array(
					'' => '',
					'Personen' => 'Personen',
					'Organisaties' => 'Organisaties',
					'Events' => 'Events',
					'Producten' => 'Producten',
					'Diensten' => 'Diensten')));    
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class
        ]);
    }
    
}

