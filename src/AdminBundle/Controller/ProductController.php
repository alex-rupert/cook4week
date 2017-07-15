<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     */
    public function indexAction()
    {
        $this->_datatable();
        
        return $this->render('AdminBundle:Crud:index.html.twig', array(
            'classLabel' => 'product',
        ));
    }

    /**
     * Creates a new product entity.
     *
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('AdminBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            
            $session = $request->getSession();
            $translator = $this->get('translator');
            $session->getFlashBag()->add('success', $translator->trans('crud.message.success.create'));

            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        return $this->render('AdminBundle:Crud:new.html.twig', array(
            'entity' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('AdminBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $session = $request->getSession();
            $translator = $this->get('translator');
            $session->getFlashBag()->add('success', $translator->trans('crud.message.success.edit'));
            
            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        return $this->render('AdminBundle:Crud:edit.html.twig', array(
            'entity' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * set datatable configs
     * 
     * @return \Ali\DatatableBundle\Util\Datatable
     */
    private function _datatable()
    {
        return $this->get('datatable')
                    ->setEntity("AdminBundle:Product", "x")
                    ->setFields(array(
                        "Name"          => 'x.name',
                        "Price"        => 'x.price',
                        "_identifier_"  => 'x.id'
                    ))
                    ->setRenderers(array(
                        array(
                            'view' => 'AdminBundle:Datatable:echoData.html.twig',
                            'params' => array(),
                        ),
                        array(
                            'view' => 'AdminBundle:Datatable:echoData.html.twig',
                            'params' => array(),
                        ),
                        array(
                            'view' => 'AdminBundle:Datatable:_action.html.twig',
                            'params' => array(),
                        ),
                    ))
                    ->setHasAction(true)
                    ->setSearch(TRUE);
        ;
    }


    /**
     * Grid action
     * @return Response
     */
    public function gridAction()
    {   
        return $this->_datatable()->execute();
    }
}
