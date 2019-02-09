<?php
	
namespace App\Form;

use App\Entity\Service;
use App\Entity\Categorie;
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
	    	->add('serviceType', TextType::class, ['label' => 'Productnaam', 'required' => true])
	    	->add('description', TextType::class, ['label' => 'Omschrijving', 'required' => false])
	    	->add('availableChannel', ChoiceType::class, [
	    		'label' => 'Communicatie Kanaal', 
	    		'required' => false,
	    		 'choices'  => array(
			        'Regulier' => 'Regulier',
			        'Mail' => 'Mail',
			        'Webshop' => 'Webshop')])
			->add('categorie', EntityType::class, array(
					    'class' => Categorie::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
					        	->andWhere('u.additionalType = :additionalType')
					        	->setParameter('additionalType', 'diensten')
					            ->orderBy('u.name', 'ASC');
					    },
					    'choice_label' => 'name',
					    'required' => true
					)); 
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class
        ]);
    }
}