<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Fridge;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Fridge controller.
 *
 */
class FridgeController extends Controller
{
    /**
     * Lists all fridge entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fridges = $em->getRepository('AdminBundle:Fridge')->findAll();

        return $this->render('fridge/index.html.twig', array(
            'fridges' => $fridges,
        ));
    }

    /**
     * Creates a new fridge entity.
     *
     */
    public function newAction(Request $request)
    {
        $fridge = new Fridge();
        $form = $this->createForm('AdminBundle\Form\FridgeType', $fridge, array(
            'user' => $this->getUser(),
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fridge);
            $em->flush();

            $session = $request->getSession();
            $translator = $this->get('translator');
            $session->getFlashBag()->add('success', $translator->trans('crud.message.success.create'));

            return $this->redirectToRoute('admin_homepage', array());
        }

        return $this->render('AdminBundle:Crud:new.html.twig', array(
            'entity' => $fridge,
            'form' => $form->createView(),
            'crudDefinition' => 'crud.definition.new.fridge',
        ));
    }

    /**
     * Finds and displays a fridge entity.
     *
     */
    public function showAction(Fridge $fridge)
    {
        $deleteForm = $this->createDeleteForm($fridge);

        return $this->render('fridge/show.html.twig', array(
            'fridge' => $fridge,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fridge entity.
     *
     */
    public function editAction(Request $request, Fridge $fridge)
    {
        $deleteForm = $this->createDeleteForm($fridge);
        $editForm = $this->createForm('AdminBundle\Form\FridgeType', $fridge);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fridge_edit', array('id' => $fridge->getId()));
        }

        return $this->render('fridge/edit.html.twig', array(
            'fridge' => $fridge,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fridge entity.
     *
     */
    public function deleteAction(Request $request, Fridge $fridge)
    {
        $form = $this->createDeleteForm($fridge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fridge);
            $em->flush();
        }

        return $this->redirectToRoute('fridge_index');
    }

    /**
     * Creates a form to delete a fridge entity.
     *
     * @param Fridge $fridge The fridge entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fridge $fridge)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fridge_delete', array('id' => $fridge->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
