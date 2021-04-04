<?php
	
namespace App\Form;

use App\Entity\Person;
use App\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class TagEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('tag', EntityType::class, array(
					    'class' => Tag::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u');
					    },
					    'choice_label' => 'tag',
					    'required' => false,
					    'multiple' => true,
                        'attr' => [
                            'class' => 'select2 select2-multiple',
                            'multiple' => 'multiple',
                            'multiple data-placeholder' => 'Select...'
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