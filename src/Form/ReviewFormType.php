<?php
	
namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ReviewFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('reviewAspect', TextType::class, ['label' => 'Titel', 'required' => true])
	    	->add('reviewBody', TextareaType::class, ['label' => 'Tekst', 'required' => false, 'attr' => array('id' => 'elm1', 'name'=>'area', 'style' => 'height: 300px')]);    
	}
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Review::class
        ]);
    }    
}
