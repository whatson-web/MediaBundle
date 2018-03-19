<?php

namespace WH\MediaBundle\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use WH\MediaBundle\Entity\File;

/**
 * @Route("/api/files")
 *
 * Class FileController
 *
 * @package WH\MediaBundle\Controller\Backend
 */
class FileController extends Controller
{
    /**
     * @Route("/upload")
     * @Method("POST")
     *
     * @param Request             $request
     * @param SerializerInterface $serializer
     *
     * @return JsonResponse
     */
    public function putFileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $uploadedFile = new UploadedFile($_FILES['file']['tmp_name'], $_FILES['file']['name']);

        $folder = date('/Y/m/d/');

        $this->get('wh_media.filemanager')->uploadFile($uploadedFile, $folder);

        $fileName = $uploadedFile->getClientOriginalName();

        $file = new File();

        $file->setAlt($fileName);
        $file->setUrl($folder.$fileName);

        $em->persist($file);
        $em->flush();

        return new JsonResponse($this->get('serializer')->serialize($file, 'jsonld'), 201, [], true);
    }

    /**
     * @Route("/upload/{file}")
     * @Method("POST")
     * @param Request             $request
     * @param SerializerInterface $serializer
     *
     * @return JsonResponse
     */
    public function updateFileAction(File $file, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $fileName = $file->getFileName();

        $uploadedFile = new UploadedFile($_FILES['file']['tmp_name'], $fileName);

        $this->get('wh_media.filemanager')->uploadFile($uploadedFile, $file->getFolder().'/');

        $file->setUpdated(new \DateTime());

        $em->persist($file);
        $em->flush();

        return new JsonResponse($this->get('serializer')->serialize($file, 'jsonld'), 201, [], true);
    }

    /**
     * @Route("/delete/{file}")
     * @Method("DELETE")
     *
     * @param File    $file
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteAction(File $file, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $this->get('wh_media.filemanager')->deleteFile($file->getUrl());

        $em->remove($file);
        $em->flush();

        return new JsonResponse(['ok' => true]);
    }
}