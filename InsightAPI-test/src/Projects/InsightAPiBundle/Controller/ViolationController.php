<?php

namespace Projects\InsightAPiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Projects\InsightAPiBundle\Entity\Violation;
use Projects\InsightAPiBundle\Form\ViolationType;

/**
 * Violation controller.
 *
 * @Route("/violation")
 */
class ViolationController extends Controller
{

    /**
     * Lists all Violation entities.
     *
     * @Route("/", name="violation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ProjectsInsightAPiBundle:Violation')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Violation entity.
     *
     * @Route("/", name="violation_create")
     * @Method("POST")
     * @Template("ProjectsInsightAPiBundle:Violation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Violation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('violation_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Violation entity.
    *
    * @param Violation $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Violation $entity)
    {
        $form = $this->createForm(new ViolationType(), $entity, array(
            'action' => $this->generateUrl('violation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Violation entity.
     *
     * @Route("/new", name="violation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Violation();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Violation entity.
     *
     * @Route("/{id}", name="violation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProjectsInsightAPiBundle:Violation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Violation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Violation entity.
     *
     * @Route("/{id}/edit", name="violation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProjectsInsightAPiBundle:Violation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Violation entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Violation entity.
    *
    * @param Violation $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Violation $entity)
    {
        $form = $this->createForm(new ViolationType(), $entity, array(
            'action' => $this->generateUrl('violation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Violation entity.
     *
     * @Route("/{id}", name="violation_update")
     * @Method("PUT")
     * @Template("ProjectsInsightAPiBundle:Violation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProjectsInsightAPiBundle:Violation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Violation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('violation_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Violation entity.
     *
     * @Route("/{id}", name="violation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ProjectsInsightAPiBundle:Violation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Violation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('violation'));
    }

    /**
     * Creates a form to delete a Violation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('violation_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
