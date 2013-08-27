<?php

namespace Innova\DirectoryBundle\Controller;

use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;

class DirectoryController extends Controller 
{
   /**
     * @Route(
     *     "/",
     *     name = "innova_directory_from_desktop",
     *     options = {"expose"=true}
     * )
     * @Template("InnovaDirectoryBundle::directory_desktop.html.twig")
     *
     */
    public function fromDesktopAction()
    {
        $userManager = $this->container->get('claroline.manager.user_manager');
        $page = $this->get('request')->query->get('page',1);
        $search = $this->get('request')->query->get('search','');
        $pager = $search === '' ?
            $userManager->getAllUsers($page) :
            $userManager->getUsersByName($search, $page);

        return array('pager' => $pager, 'search' => $search);
    }

    /**
     * @Route(
     *     "/",
     *     name = "innova_directory_from_workspace",
     *     options = {"expose"=true}
     * )
     *
     * @Template("InnovaDirectoryBundle::directory_workspace.html.twig")
     *
     */
    public function fromWorkspaceAction()
    {
        $userManager = $this->container->get('claroline.manager.user_manager');
        $page = $this->get('request')->query->get('page',1);
        $search = $this->get('request')->query->get('search','');
        
        $id = $this->get('request')->query->get('id');
        $em = $this->container->get('doctrine.orm.entity_manager');
        $workspace = $em->getRepository('ClarolineCoreBundle:Workspace\AbstractWorkspace')->find($id);

        $pager = $search === '' ?
            $userManager->getUsersByWorkspace($workspace, $page) :
            $userManager->getUsersByWorkspaceAndName($workspace, $search, $page);

        return array('workspace' => $workspace, 'pager' => $pager, 'search' => $search);
    }

}
     

     