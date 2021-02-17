<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageController extends AbstractController
{
    /**
     * @Route("/product/{id}/image/upload", name="image_upload")
     * @IsGranted("ROLE_PRODUCT_CREATE")
     */
    public function index(EntityManagerInterface $em, Request $request, TranslatorInterface $translator, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Products::class)->find($id);
        $productID = $product->getId();

        return $this->render('products/product-imageForm.html.twig', [
            'id' => $productID
        ]);
    }

    /**
     * @Route("/product/{id}/image/dropzone", name="image_dropzone")
     * @IsGranted("ROLE_PRODUCT_CREATE")
     */
    public function image_dropzone(EntityManagerInterface $em, Request $request, $id)
    {

        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }


        $file = new UploadedFile($uploadedFile, $uploadedFile, null, null, true);

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Products::class)->find($id);

        $image = new Image();
        $image->setProducts($product);
        $image->setImageFile($file);

        $em->persist($image);
        $em->flush();

    // return data to the frontend
    return new JsonResponse([]);

    }

    /**
     * @Route("/product/{product_id}/image/{image_id}/delete", name="image_delete")
     * @IsGranted("ROLE_PRODUCT_DELETE")
     */
    public function del(EntityManagerInterface $em, Request $request, $product_id, $image_id, TranslatorInterface $translator)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Products::class)->find($product_id);
        $productID = $product->getId();



        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Image::class)->find($image_id);
        if (!$data) {
            throw $this->createNotFoundException();
        }

        $em->remove($data);
        $em->flush();

       $this->addFlash('warning', $translator->trans('Image').' '.$translator->trans('flash_message_delete'));

        return $this->redirectToRoute('product_id', array('id' => $productID, '_fragment' => 'images'));
    }



}
