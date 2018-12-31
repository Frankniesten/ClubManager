<?php
	
namespace App\Form;

use App\Entity\Products;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('name', TextType::class, ['label' => 'Productnaam', 'required' => true])
	    	->add('description', TextType::class, ['label' => 'Omschrijving', 'required' => false])
	    	->add('productID', TextType::class, ['label' => 'Serienummer', 'required' => false])
			->add('model', TextType::class, ['label' => 'Model', 'required' => false])
			->add('manufacturer', TextType::class, ['label' => 'Fabrikant', 'required' => false])
			->add('purchaseDate', DateType::class, ['label' => 'Aankoopdatum', 'required' => false, 'widget' => 'single_text', 'html5' => false,])
			->add('categorie', EntityType::class, array(
					    'class' => Categorie::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
					        	->andWhere('u.additionalType = :additionalType')
					        	->setParameter('additionalType', 'producten')
					            ->orderBy('u.name', 'ASC');
					    },
					    'choice_label' => 'name',
					    'required' => true
					)); 
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class
        ]);
    }
}
