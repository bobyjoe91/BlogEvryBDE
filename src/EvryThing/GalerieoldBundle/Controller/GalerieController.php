<?php

namespace EvryThing\GalerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EvryThing\DocumentBundle\Entity\Document;
use EvryThing\DocumentBundle\Form\DocumentType;

class GalerieController extends Controller
{
    public function displayAlbumsAction()
    {
		/************* On parcours les albums ****************/
		$pointeur=opendir('./bundles/evrythinggalerie/images/');
		while ($entree = readdir($pointeur)) {
		 /* on n'affiche que les entrees voulues */
			if ($entree != "." && $entree != "..") {
				$albums[] = "$entree";
			}
		}
		closedir($pointeur);
        return $this->render('EvryThingGalerieBundle:Galerie:albums.html.twig', array('albums' => $albums));
    }
	
	public function displayCarrouselAction($album)
    {
		$pointeur=opendir('./bundles/evrythinggalerie/images/'.$album);
		while ($entree = readdir($pointeur)) {
		 /* on n'affiche que les entrees voulues */
			if ($entree != "." && $entree != "..") {
				$photos[] = "$entree";
			}
		}
		closedir($pointeur);
        return $this->render('EvryThingGalerieBundle:Galerie:carrousel.html.twig', array('photos' => $photos, 'album' => $album));
    }
	
	public function adminAction()
    {
		$pointeur=opendir('./bundles/evrythinggalerie/images/');
		while ($entree = readdir($pointeur)) {
		 /* on n'affiche que les entrees voulues */
			if ($entree != "." && $entree != "..") {
				$albums[] = "$entree";
			}
		}
		closedir($pointeur);
		
		/************* formulaire d'upload ****************/
		$photo = new Document;
		$form = $this->createForm(new DocumentType($albums), $photo);
		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				$photo->upload($albums);	
				$em = $this->getDoctrine()->getManager();
				$em->persist($photo);
				$em->flush();
				return $this->redirect($this->generateUrl('evry_thing_accueil'));
			}
		}
        return $this->render('EvryThingGalerieBundle:Galerie:admin.html.twig', array('albums' => $albums, 'form' => $form->createView()));
    }
}
