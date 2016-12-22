<?php

namespace Arkounay\ImageBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller
{

    /**
     * @Route("/ajax-image-upload", name="admin_ajax_image_upload")
     */
    public function ajaxImageUploadAction(Request $request)
    {
        $path = $this->get('kernel')->getRootDir() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'uploads';
        $files = $request->files->all();
        $res = [];
        foreach ($files as $file) {
            /** @var UploadedFile $file */
            if (in_array($file->getMimeType(), [image_type_to_mime_type(IMAGETYPE_GIF), image_type_to_mime_type(IMAGETYPE_JPEG), image_type_to_mime_type(IMAGETYPE_PNG)])) {
                $basename = basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension());
                $newname = $basename . '.' . $file->guessExtension();
                while (file_exists($path . DIRECTORY_SEPARATOR . $newname)) {
                    $newname = $basename . '_' . substr(sha1(uniqid(mt_rand(), true)), 0, 8) . '.' . $file->guessExtension();
                }
                $file->move($path, $newname);
                $res[] = DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $newname;
            } else {
                $res[] = false;
            }
        }
        return new JsonResponse($res);
    }


}
