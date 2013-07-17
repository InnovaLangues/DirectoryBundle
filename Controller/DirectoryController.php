<?php

namespace Innova\DirectoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DirectoryController extends Controller
{
    /**
     * @Route(
     *     "/",
     *     name = "innova_directory"
     * )
     *
     * @return Response
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        //get the resource
        // $resource = $em->getRepository('ClarolineCoreBundle:Resource\AbstractResource')->find($id);

        $em = $this->getDoctrine()->getManager();
        //$paths = $em->getRepository('InnovaPathBundle:Path')->findAll();

        //get the text.
        // return array('_resource' => $resource);
        return array(
           // 'paths' => $paths,
        );
    }
}