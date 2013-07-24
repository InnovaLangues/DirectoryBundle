<?php

namespace Innova\DirectoryBundle\Listener;

use Claroline\CoreBundle\Event\Event\DisplayToolEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ToolListener extends ContainerAware
{
    public function onWorkspaceOpen(DisplayToolEvent $event)
    {
        $id = $event->getWorkspace()->getId();
        $subRequest = $this->container->get('request')->duplicate(array('page'=>1,'search'=>'', 'id'=>$id), array(), array("_controller" => 'InnovaDirectoryBundle:Directory:fromWorkspace'));
        $response = $this->container->get('http_kernel')->handle($subRequest, HttpKernelInterface::SUB_REQUEST); 
        $event->setContent($response->getContent());
    }

    public function onDesktopOpen(DisplayToolEvent $event)
    {
        $subRequest = $this->container->get('request')->duplicate(array('page'=>1,'search'=>''), array(), array("_controller" => 'InnovaDirectoryBundle:Directory:fromDesktop'));
        $response = $this->container->get('http_kernel')->handle($subRequest, HttpKernelInterface::SUB_REQUEST); 
        $event->setContent($response->getContent());

    }

    

    // private function workspace($id)
    // {
    //     //if you want to keep the context, you must retrieve the workspace.
    //     $em = $this->container->get('doctrine.orm.entity_manager');
    //     $workspace = $em->getRepository('ClarolineCoreBundle:Workspace\AbstractWorkspace')->find($id);

    //     $userManager = $this->container->get('claroline.manager.user_manager');
    //     $users = $userManager->getUsersByWorkspace($workspace);

    //     return $this->container->get('templating')->render(
    //         'InnovaDirectoryBundle::directory.html.twig', array('users' => $users)
    //     );
    // }

    // private function desktop()
    // {
    //     $userManager = $this->container->get('claroline.manager.user_manager');
    //     $users = $userManager->getAll();

    //     return $this->container->get('templating')->render(
    //         'InnovaDirectoryBundle::directory.html.twig', array('users' => $users)
    //     );
    // }
}