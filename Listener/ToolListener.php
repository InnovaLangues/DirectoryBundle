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
}