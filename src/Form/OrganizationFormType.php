<?php
	
namespace App\Form;

use App\Entity\Organization;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class OrganizationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('legalName', TextType::class, ['required' => true])
	    	->add('description', TextType::class, ['required' => false])
	    	->add('email', EmailType::class, ['required' => false])
			->add('telephone', TextType::class, ['required' => false])
			->add('telephone_2', TextType::class, ['required' => false])
			
			->add('streetAddress', TextType::class, ['required' => false])
			->add('postOfficeBoxNumber', TextType::class, ['required' => false])
			->add('postalCode', TextType::class, ['required' => false])
			->add('addressLocality', TextType::class, ['required' => false])
            ->add('addressCountry', CountryType::class,
                [
                    'required' => false,
                    'attr' => ['class' => 'select2'],
                    'placeholder' => 'Selecteer...',
                ])
			->add('leiCode', TextType::class, ['required' => false])
			->add('vatID', TextType::class, ['required' => false])
			->add('url', UrlType::class, ['label' => 'Website', 'required' => false])
			->add('category', EntityType::class, array(
					    'class' => Category::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
					        	->andWhere('u.additionalType = :additionalType')
					        	->setParameter('additionalType', 'organization')
					            ->orderBy('u.name', 'ASC');
					    },
					    'choice_label' => 'name',
					    'required' => true,
					    'placeholder' => 'Selecteer...',
					    'attr' => [
							'class' => 'select2'
						]
					));
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organization::class
        ]);
    }
}

