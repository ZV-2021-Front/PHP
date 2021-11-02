<?php

namespace App\Controller;

use Validator\GetValidator;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FieldsController extends AbstractController
{
    /**
     * @Route("/api/fields", name="fields")
     */
    public function index(): Response
    {
        
        $fields = GetValidator::getFields($this->getDoctrine()->getManager(), 'apples');
        if(isset($product['error'])){return $this->json($fields);}

        return $this->json([
            'message' => 'Returned',
            'data' => $fields,
        ]);
    }
}
