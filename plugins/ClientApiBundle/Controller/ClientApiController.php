<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 9/2/15
 * Time: 12:40 PM
 */

namespace MauticAddon\ClientApiBundle\Controller;

use Mautic\CoreBundle\Controller\FormController;
use MauticAddon\ClientApiBundle\Entity\ClientApi;



class ClientApiController extends FormController {

    public function indexAction($page = 1)
    {
        $model   = $this->factory->getModel('addon.clientApi.clientApi');
        //set limits
        $limit = 5;
        $start = ($page === 1) ? 0 : (($page - 1) * $limit);
        if ($start < 0) {
            $start = 0;
        }

        $results = $model->getEntities(
            array(
                'start'          => 0,
                'limit'          => 20,
                'filter'         => [],
                'orderBy'        => [],
                'orderByDir'     => [],
                'withTotalCount' => true
            )
        );

        $count   = $results->count();
        // unset($results['count']);


        /* $clientApis = $results-();
         unset($results);*/

        if ($count && $count < ($start + 1)) {
            //the number of entities are now less then the current page so redirect to the last page
            if ($count === 1) {
                $lastPage = 1;
            } else {
                $lastPage = (ceil($count / $limit)) ?: 1;
            }

            $returnUrl = $this->generateUrl('client_api_index', array('page' => $lastPage));

            return $this->postActionRedirect(
                array(
                    'returnUrl'       => $returnUrl,
                    'viewParameters'  => array('page' => $lastPage),
                    'contentTemplate' => 'CleantApiBundle:ClientApi:index',
                    'passthroughVars' => array(
                        'activeLink'    => '#client_api_index',
                        'mauticContent' => 'client_api'
                    )
                )
            );
        }


        $tmpl = $this->request->isXmlHttpRequest() ? $this->request->get('tmpl', 'index') : 'index';




        // We need the EmailRepository to check if a lead is flagged as do not contact
        /** @var \Mautic\EmailBundle\Entity\EmailRepository $emailRepo */

        $indexMode = 'list';
        // Get the max ID of the latest lead added
        $maxLeadId = $model->getRepository()->getMaxClientApiId();

        return $this->delegateView(
            array(
                'viewParameters'  => array(
                    'searchValue'   => '',
                    'items'         => $results,
                    'page'          => $page,
                    'totalItems'    => $count,
                    'limit'         => $limit,
                    'indexMode'     => $indexMode,
                    'maxLeadId'     => $maxLeadId
                ),
                'contentTemplate' => "ClientApiBundle:ClientApi:{$indexMode}.html.php",
                'passthroughVars' => array(
                    'activeLink'    => '#client_api_index',
                    'mauticContent' => 'clientApi',
                    'route'         => $this->generateUrl('client_api_index', array('page' => $page))
                )
            )
        );
    }


    public function newAction()
    {
        //retrieve the entity
        $clientApi     = new ClientApi();
        $model      =$this->factory->getModel('addon.clientApi.clientApi');
        //set the page we came from
        $page       = $this->factory->getSession()->get('addon.clientapi.page', 1);
        //set the return URL for post actions
        $returnUrl  = $this->generateUrl('client_api_index', array('page' => $page));
        $action     = $this->generateUrl('mautic_client_api_action', array('objectAction' => 'new'));

        $form       = $model->createForm($clientApi, $this->get('form.factory'),  $action);


        ///Check for a submitted form and process it
        if ($this->request->getMethod() == 'POST') {
            $valid = false;
            if (!$cancelled = $this->isFormCancelled($form)) {
                if ($valid = $this->isFormValid($form)) {
                    //form is valid so process the data
                    $model->saveEntity($clientApi);

                    $this->addFlash('mautic.core.notice.created',  array(
                        '%name%'      => $clientApi->getName(),
                        '%menu_link%' => 'client_api_index',
                        '%url%'       => $this->generateUrl('mautic_client_api_action', array(
                                'objectAction' => 'edit',
                                'objectId'     => $clientApi->getId()
                            ))
                    ));
                }
            }

            if ($cancelled || ($valid && $form->get('buttons')->get('save')->isClicked())) {
                return $this->postActionRedirect(array(
                    'returnUrl'       => $returnUrl,
                    'viewParameters'  => array('page' => $page),
                    'contentTemplate' => 'ClientApiBundle:ClientApi:index',
                    'passthroughVars' => array(
                        'activeLink'    => '#client_api_index',
                        'mauticContent' => 'clientapi'
                    )
                ));
            } elseif ($valid && !$cancelled) {
                return $this->editAction($clientApi->getId(), true);
            }
        }

        return $this->delegateView(array(
            'viewParameters'  => array(
                'form'            => $form->createView(),
                'clientApi'       => $clientApi,
            ),
            'contentTemplate' => 'ClientApiBundle:ClientApi:form.html.php',

            'passthroughVars' => array(
                'activeLink'    => '#client_api_index',
                'route'         => $this->generateUrl('mautic_client_api_action', array('objectAction' => 'new')),
                'mauticContent' => 'clientapi'
            )
        ));
    }

    public function editAction($objectId, $ignorePost = false)
    {
        //retrieve the entity
        $model      = $this->factory->getModel('addon.clientApi.clientApi');
        $clientApi     = $model->getEntity($objectId);

        //set the page we came from
        $page       = $this->factory->getSession()->get('addon.clientapi.page', 1);
        //set the return URL for post actions
        $returnUrl  = $this->generateUrl('client_api_index', array('page' => $page));


        $postActionVars = array(
            'returnUrl'       => $returnUrl,
            'viewParameters'  => array('page' => $page),
            'contentTemplate' => 'ClientApiBundle:ClientApi:index',
            'passthroughVars' => array(
                'activeLink'    => '#client_api_index',
                'mauticContent' => 'lead'
            )
        );

        //lead not found
        /*if ($lead === null) {
            return $this->postActionRedirect(
                array_merge(
                    $postActionVars,
                    array(
                        'flashes' => array(
                            array(
                                'type'    => 'error',
                                'msg'     => 'addon.lead.lead.error.notfound',
                                'msgVars' => array('%id%' => $objectId)
                            )
                        )
                    )
                )
            );
        } elseif (!$this->factory->getSecurity()->hasEntityAccess(
            'lead:leads:editown',
            'lead:leads:editother',
            $lead->getOwner()
        )
        ) {
            return $this->accessDenied();
        } elseif ($model->isLocked($lead)) {
            //deny access if the entity is locked
            return $this->isLocked($postActionVars, $lead, 'lead.lead');
        }*/

        $action = $this->generateUrl('mautic_client_api_action', array('objectAction' => 'edit', 'objectId' => $objectId));

        $form   = $model->createForm($clientApi, $this->get('form.factory'), $action);


        ///Check for a submitted form and process it
        if (!$ignorePost && $this->request->getMethod() == 'POST') {
            $valid = false;
            if (!$cancelled = $this->isFormCancelled($form)) {
                if ($valid = $this->isFormValid($form)) {
                    //form is valid so process the data
                    $model->saveEntity($clientApi);

                    $this->addFlash('mautic.core.notice.updated',  array(
                        '%name%'      => $clientApi->getName(),
                        '%menu_link%' => 'client_api_index',
                        '%url%'       => $this->generateUrl('mautic_client_api_action', array(
                                'objectAction' => 'edit',
                                'objectId'     => $clientApi->getId()
                            ))
                    ));
                }
            }

            if ($cancelled || ($valid && $form->get('buttons')->get('save')->isClicked())) {
                return $this->postActionRedirect(array(
                    'returnUrl'       => $returnUrl,
                    'viewParameters'  => array('page' => $page),
                    'contentTemplate' => 'ClientApiBundle:ClientApi:index',
                    'passthroughVars' => array(
                        'activeLink'    => '#client_api_index',
                        'mauticContent' => 'clientapi'
                    )
                ));

            } elseif ($valid && !$cancelled) {
                return $this->editAction($clientApi->getId(), true);
            }
        }

        return $this->delegateView(array(
            'viewParameters'  => array(
                'form'            => $form->createView(),
                'clientApi'       => $clientApi,
            ),
            'contentTemplate' => 'ClientApiBundle:ClientApi:form.html.php',

            'passthroughVars' => array(
                'activeLink'    => '#client_api_index',
                'route'         => $this->generateUrl('mautic_client_api_action', array('objectAction' => 'edit')),
                'mauticContent' => 'clientapi'
            )
        ));
    }

    /**
     * Deletes the entity
     *
     * @param         $objectId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($objectId)
    {
        $page      = $this->factory->getSession()->get('addon.clientapi.page', 1);
        $returnUrl = $this->generateUrl('mautic_lead_index', array('page' => $page));
        $flashes   = array();

        $postActionVars = array(
            'returnUrl'       => $returnUrl,
            'viewParameters'  => array('page' => $page),
            'contentTemplate' => 'ClientApiBundle:ClientApi:index',
            'passthroughVars' => array(
                'activeLink'    => '#client_api_index',
                'mauticContent' => 'clientApi'
            )
        );

        if ($this->request->getMethod() == 'POST') {
            $model  = $this->factory->getModel('addon.clientApi.clientApi');
            $entity = $model->getEntity($objectId);

            if ($entity === null) {
                $flashes[] = array(
                    'type'    => 'error',
                    'msg'     => 'addon.clientApi.clientApi.error.notfound',
                    'msgVars' => array('%id%' => $objectId)
                );
            } /*elseif (!$this->factory->getSecurity()->hasEntityAccess(
                'lead:leads:deleteown',
                'lead:leads:deleteother',
                $entity->getOwner()
            )
            ) {
                return $this->accessDenied();
            } elseif ($model->isLocked($entity)) {
                return $this->isLocked($postActionVars, $entity, 'lead.lead');
            }*/ else {
                $model->deleteEntity($entity);

                $identifier = $this->get('translator')->trans($entity->getPrimaryIdentifier());
                $flashes[]  = array(
                    'type'    => 'notice',
                    'msg'     => 'mautic.core.notice.deleted',
                    'msgVars' => array(
                        '%name%' => $identifier,
                        '%id%'   => $objectId
                    )
                );
            }
        } //else don't do anything

        return $this->postActionRedirect(
            array_merge(
                $postActionVars,
                array(
                    'flashes' => $flashes
                )
            )
        );
    }

    /**
     * Deletes a group of entities
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function batchDeleteAction()
    {
        $page      = $this->factory->getSession()->get('addon.clientapi.page', 1);
        $returnUrl = $this->generateUrl('mautic_lead_index', array('page' => $page));
        $flashes   = array();

        $postActionVars = array(
            'returnUrl'       => $returnUrl,
            'viewParameters'  => array('page' => $page),
            'contentTemplate' => 'ClientApiBundle:ClientApi:index',
            'passthroughVars' => array(
                'activeLink'    => '#client_api_index',
                'mauticContent' => 'clientApi'
            )
        );

        if ($this->request->getMethod() == 'POST') {
            $model  = $this->factory->getModel('addon.clientApi.clientApi');
            $ids       = json_decode($this->request->query->get('ids', '{}'));
            $deleteIds = array();

            // Loop over the IDs to perform access checks pre-delete
            foreach ($ids as $objectId) {
                $entity = $model->getEntity($objectId);

                if ($entity === null) {
                    $flashes[] = array(
                        'type'    => 'error',
                        'msg'     => 'addon.clientApi.clientApi.error.notfound',
                        'msgVars' => array('%id%' => $objectId)
                    );
                } /*elseif (!$this->factory->getSecurity()->hasEntityAccess(
                    'lead:leads:deleteown',
                    'lead:leads:deleteother',
                    $entity->getCreatedBy()
                )
                ) {
                    $flashes[] = $this->accessDenied(true);
                } elseif ($model->isLocked($entity)) {
                    $flashes[] = $this->isLocked($postActionVars, $entity, 'lead', true);
                }*/ else {
                    $deleteIds[] = $objectId;
                }
            }

            // Delete everything we are able to
            if (!empty($deleteIds)) {
                $entities = $model->deleteEntities($deleteIds);

                $flashes[] = array(
                    'type'    => 'notice',
                    'msg'     => 'addon.clientApi.clientApi.notice.batch_deleted',
                    'msgVars' => array(
                        '%count%' => count($entities)
                    )
                );
            }
        } //else don't do anything

        return $this->postActionRedirect(
            array_merge(
                $postActionVars,
                array(
                    'flashes' => $flashes
                )
            )
        );
    }

}