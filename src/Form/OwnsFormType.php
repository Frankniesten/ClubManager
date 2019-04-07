<?php
	
namespace App\Form;

use App\Entity\Person;
use App\Entity\Organization;
use App\Entity\Products;
use App\Entity\OwnershipInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;

class OwnsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('ownedFrom', DateType::class, ['label' => 'In bezit vanaf', 'required' => true, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy'])
	    	->add('ownedTrough', DateType::class, ['label' => 'In bezit tot', 'required' => false, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy'])			
			->add('typeofGood', EntityType::class, array(
					    'class' => Products::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
								->where('u.loan = false OR u.loan IS NULL')
					            ->orderBy('u.name', 'ASC');
					    },
					    'choice_label' => 'name',
					    'required' => true,
					    'label' => 'Product',
					    'placeholder' => 'Selecteer...',
					    'attr' => [
							'class' => 'select2'
						]
					));
	
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OwnershipInfo::class
        ]);
    }
}

