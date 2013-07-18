<?php

namespace Innova\DirectoryBundle\Listener;

use Claroline\CoreBundle\Event\Event\DisplayToolEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Claroline\CoreBundle\Entity\User;

class ToolListener extends ContainerAware
{
    public function onWorkspaceOpen(DisplayToolEvent $event)
    {
        $event->setContent($this->workspace($event->getWorkspace()->getId()));
    }

    public function onDesktopOpen(DisplayToolEvent $event)
    {
        $event->setContent($this->desktop());
    }

    private function workspace($id)
    {
        //if you want to keep the context, you must retrieve the workspace.
        $em = $this->container->get('doctrine.orm.entity_manager');
        $workspace = $em->getRepository('ClarolineCoreBundle:Workspace\AbstractWorkspace')->find($id);

        $userManager = $this->container->get('claroline.manager.user_manager');
        $users = $userManager->getUsersByWorkspace($workspace);

        return $this->container->get('templating')->render(
            'InnovaDirectoryBundle::directory.html.twig', array('users' => $users)
        );
    }

    private function desktop()
    {
        $userManager = $this->container->get('claroline.manager.user_manager');
        $users = $userManager->getAll();

        return $this->container->get('templating')->render(
            'InnovaDirectoryBundle::directory.html.twig', array('users' => $users)
        );
    }
}