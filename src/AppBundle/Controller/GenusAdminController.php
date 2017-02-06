<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use AppBundle\Form\GenusFormType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin")
 */
class GenusAdminController extends BaseController
{
    /**
     * @Route("/genus", name="admin_genus_index")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $genuses = $this->getRepository(Genus::class)->findAll();

        return $this->render('admin/genus/list.html.twig', [
            'genuses' => $genuses,
        ]);
    }

    /**
     * @Route("/genus/create", name="admin_genus_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(GenusFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getManager();
            $manager->persist($form->getData());
            $manager->flush();

            $message = sprintf('Genus created by you: %s!', $this->getUser()->getEmail());
            $this->addFlash('success', $message);

            return $this->redirectToRoute('admin_genus_index');
        }

        return $this->render('admin/genus/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/genus/{id}/edit", name="admin_genus_edit")
     */
    public function editAction(Request $request, Genus $genus)
    {
        $form = $this->createForm(GenusFormType::class, $genus);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getManager();
            $manager->persist($form->getData());
            $manager->flush();

            $this->addFlash('success', 'Genus updated!');

            return $this->redirectToRoute('admin_genus_index');
        }

        return $this->render('admin/genus/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
