<?php
	
namespace App\Form;

use App\Entity\Organization;
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

class OrganizationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('legalName', TextType::class, ['label' => 'Naam', 'required' => true])
	    	->add('description', TextType::class, ['label' => 'Omschrijving', 'required' => false])
	    	->add('email', EmailType::class, ['label' => 'Email', 'required' => false])
			->add('telephone', TextType::class, ['label' => 'Telefoon', 'required' => false])
			->add('telephone_2', TextType::class, ['label' => 'Mobiel', 'required' => false])
			
			->add('streetAddress', TextType::class, ['label' => 'Straat', 'required' => false])
			->add('postOfficeBoxNumber', TextType::class, ['label' => 'Postbus', 'required' => false])
			->add('postalCode', TextType::class, ['label' => 'Postcode', 'required' => false])
			->add('addressLocality', TextType::class, ['label' => 'Woonplaats', 'required' => false])
			->add('addressCountry', ChoiceType::class, [
	    		'label' => 'Land', 
	    		'required' => false,
	    		 'choices'  => array(
			        'Nederland' => 'Nederland',
			        'België' => 'België',
			        'Duitsland' => 'Duitsland')])
			        
			        
			->add('leiCode', TextType::class, ['label' => 'K.v.K. Nummer', 'required' => false])
			->add('vatID', TextType::class, ['label' => 'Belasting Nummer', 'required' => false])
			->add('url', UrlType::class, ['label' => 'Website', 'required' => false])
			->add('categorie', EntityType::class, array(
					    'class' => Categorie::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
					        	->andWhere('u.additionalType = :additionalType')
					        	->setParameter('additionalType', 'organisaties')
					            ->orderBy('u.name', 'ASC');
					    },
					    'choice_label' => 'name',
					    'required' => true
					));
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organization::class
        ]);
    }
}

