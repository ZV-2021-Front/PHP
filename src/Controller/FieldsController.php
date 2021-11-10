<?php

namespace App\Controller;

use Validator\GetValidator;

use App\Repository\RussianAliasesRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FieldsController extends AbstractController
{
    //переопределяю функцию json ибо AbstractController всегда ставит параметры json-кодирования на DEFAULT_ENCODING_OPTIONS, который равен 15
    // а нужно 256 (битовая маска JSON_UNESCAPED_UNICODE), что бы не было ненужного экранироавния
    public const CUSTOM_ENCODING_OPTIONS = 256;
    protected function json($data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        if ($this->container->has('serializer')) {
            $json = $this->container->get('serializer')->serialize($data, 'json', array_merge([
                'json_encode_options' => self::CUSTOM_ENCODING_OPTIONS,
            ], $context));

            return new JsonResponse($json, $status, $headers, true);
        }

        return new JsonResponse($data, $status, $headers);
    }
    
    /**
     * @Route("/api/fields", name="fields")
     */
    public function index(RussianAliasesRepository $RussianAliasesRepository, Request $request): Response
    {
        
        $GET = $request->query->all();

        
        $table_name = GetValidator::checkGetTableName($GET);
        if(isset($table_name['error'])){return $this->json($table_name);}
        
        $fields = GetValidator::getFields($this->getDoctrine()->getManager(), $table_name);

        return $this->json($data = $RussianAliasesRepository->getAliases($fields));
    }
}
