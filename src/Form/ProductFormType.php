<?php
	
namespace App\Form;

use App\Entity\Products;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('name', TextType::class, ['required' => true])
	    	->add('description', TextType::class, ['required' => false])
	    	->add('productID', TextType::class, ['required' => false])
			->add('model', TextType::class, ['required' => false])
			->add('manufacturer', TextType::class, ['required' => false])
			->add('purchaseDate', DateType::class, ['required' => false, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy'])
			->add('uniqueProduct', CheckboxType::class, ['required' => false, 'attr' => ['data-plugin' => 'switchery']])
			->add('identifier', TextType::class, ['required' => false])
            ->add('additionalProperty', TextType::class, ['required' => false])
			->add('category', EntityType::class, array(
					    'class' => Category::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
					        	->andWhere('u.additionalType = :additionalType')
					        	->setParameter('additionalType', 'product')
					            ->orderBy('u.name', 'ASC');
					    },
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
            'data_class' => Products::class
        ]);
    }
}

