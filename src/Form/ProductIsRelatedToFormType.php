<?php
	
namespace App\Form;

use App\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;

class ProductIsRelatedToFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	   	$this->productId = $options['productId'];
	    
	    $builder
	    	->add('isRelatedTo', EntityType::class, array(
					    'class' => Products::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
					        ->where('u.id != :selfId')
					        ->orderBy('u.name', 'ASC')
					        ->setParameter('selfId', $this->productId);
					    },
					    'choice_label' => function (Products $product) {return 'Naam: ' .

						    $product->getName(). ', SN: ' .
						    $product->getProductID(). ', Model: ' .
						    $product->getModel(). ', Fabrikant: ' .
						    $product->getManufacturer(); 
						    
						    },
					    'required' => false,
					    'label' => 'Gerelateerd product',
					    'multiple' => true
					));
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
        	->setDefaults(['data_class' => Products::class])
        	->setRequired('productId')
			->setAllowedTypes('productId', array('string'));
    }
}


