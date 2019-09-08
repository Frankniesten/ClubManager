<?php
namespace App\Controller;
use App\Entity\Person;
use App\Entity\Membership;
use App\Entity\Category;
use App\Form\PersonFormType;
use App\Form\ReviewFormType;
use App\Form\MembershipFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
class PeopleController extends AbstractController
{
    /**
     * @Route("/people", name="app_people")
     * @IsGranted("ROLE_PERSON_VIEW")
     *
     */
	public function list(SessionInterface $session, EntityManagerInterface $em, Request $request)
	{
		
		$people = null;
		$query = null;
		$roles = null;
		
		//Check for roles query:       
	    if ($roles= $request->query->get('roles'))
	    {		    
		    $em = $this->getDoctrine()->getManager();
			$people = $em->getRepository(Person::class)->findByMemberOfProgramName($roles); 	
	    }
	   
    	//Check categorie query:       
	    else if ($query = $request->query->get('query'))
	    {
		    $session->set('event_query', $query);
		    
		    if ($query == 'all')
		    {
			    $query = $session->get('event_query', 'all');
			    $people = $this->getDoctrine()
		        ->getRepository(Person::class)
		        ->findAll();  
		    }
		    else 
		    {
			    $em = $this->getDoctrine()->getManager();
				$people = $em->getRepository(Person::class)->findByCategegory($query);  
		    }
	    }
	    else 
	    {
		    $query = $session->get('event_query', 'all');
		    $people = $this->getDoctrine()
	        ->getRepository(Person::class)
	        ->findAll(); 
	    }
        
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository(Category::class)->findCategoryType('person');
				
		return $this->render('people/people.html.twig', [
        	'data' => $people,
        	'club_name' => getenv('CLUB_NAME'),
        	'category' => $category,
        	'query' => $query,
        	'roles' => $roles
		]);
		
		
		
		
	}
	/**
     * @Route("/person/create", name="app_person_create")
     * @IsGranted("ROLE_PERSON_CREATE")
     */
	public function new(EntityManagerInterface $em, Request $request)
	{
		$form = $this->createForm(PersonFormType::class);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$person = $form->getData();
			
			$em->persist($person);
			$em->flush();
			$id = $person->getId();
           
			$this->addFlash('success', $person->getFamilyName().', '.$person->getGivenName().' '.$person->getAdditionalName().' is aangemaakt!');
			
			return $this->redirectToRoute('app_person', array('id' => $id));			
		}
		
		return $this->render('people/personForm.html.twig', [
        	'form' => $form->createView()
		]);
	}
	/**
     * @Route("/person/{id}", name="app_person")
     * @IsGranted("ROLE_PERSON_VIEW")
     */
	public function show(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
		
		if (!$person) {
        	throw $this->createNotFoundException('Deze persoon bestaat niet');
    	} 
        
		return $this->render('people/person.html.twig', [
        	'data' => $person
		]);
	}
		
	/**
     * @Route("/person/{id}/edit", name="app_person_edit")
     * @IsGranted("ROLE_PERSON_EDIT")
     */
	public function edit(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
		        
        if (!$person) {
        	throw $this->createNotFoundException('Deze persoon bestaat niet');
    	} 
    	
		$form = $this->createForm(PersonFormType::class, $person);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$person = $form->getData();
			
			$em->persist($person);
			$em->flush();
           
			$this->addFlash('success', $person->getFamilyName().', '.$person->getGivenName().' '.$person->getAdditionalName().' is bijgewerkt!');
			
			return $this->redirectToRoute('app_person', array('id' => $id));			
		}
		
		return $this->render('people/personForm.html.twig', [
        	'form' => $form->createView(),
        	'data' => $person
		]);
	}
	
	
	/**
     * @Route("/person/{id}/delete", name="person_delete")
     * @IsGranted("ROLE_PERSON_DELETE")
     */
	public function del(EntityManagerInterface $em, Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$person = $em->getRepository(Person::class)->find($id);
		if (!$person) {
        	throw $this->createNotFoundException('Deze persoon bestaat niet');
    	} 
    	
		$em->remove($person);
		$em->flush();
       
		$this->addFlash('warning', 'Persoon is verwijderd!');
		
		return $this->redirectToRoute('app_people');			
}
}