<?php

namespace WH\MediaBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FinderController
 *
 * @package WH\MediaBundle\Controller\Backend
 */
class FinderController extends Controller
{
    /**
     * @Route("/wh_finder", name="bk_wh_media_file_finder")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function finderAction()
    {
        return $this->render(
            '@WHMedia/Backend/File/finder.html.twig'
        );
    }
}