<?php
	
namespace App\Form;

use App\Entity\Education;
use App\Entity\Organization;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;

class EducationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('certificate', TextType::class, ['label' => 'Diploma', 'required' => true])
	    	->add('dataAchieved', DateType::class, ['label' => 'Behaald', 'required' => false, 'widget' => 'single_text', 'html5' => false,])
	    	->add('organization', EntityType::class, array(
					    'class' => Organization::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
					            ->orderBy('u.legalName', 'ASC');
					    },
					    'choice_label' => 'legalName',
					    'required' => false,
					    'label' => 'Muziekschool',
					    'attr' => [
							'class' => 'select2'
						]
				)); 
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Education::class
        ]);
    }
}
