<?php

// require_once "bootstrap.php";

namespace App\Controller;

use Validator\GetValidator;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\HttpFoundation\JsonResponse;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LineGraphController extends AbstractController
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
     * @Route("api/linear", name="line_graph")
     */
    public function index(Connection $conn, Request $request): Response
    // function linearHandler(string $xAxisField, string $yAxisField, array $products, array $date, $data_base)
    {
        // return $this->json([
        //     'message' => 'Welcome to your new controller!',
        //     'path' => 'src/Controller/LineGraphController.php',
        // ]);
        // LineGraphController::setEncodingOptions(256);
        // $response = new JsonResponse(['message' => "'"]);
        // $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);

        // return $response;

        
        
        
        $GET = $request->query->all();
        // return $this->json($GET);

        $products = GetValidator::checkGetParamProducts($GET);
        if(isset($products['error'])){return $this->json($products);}

        $date = GetValidator::checkGetParamDate($GET);
        if(isset($date['error'])){return $this->json($date);}
            

        $fields = GetValidator::getFields($this->getDoctrine()->getManager(), 'apples');

        $xAxisField = GetValidator::checkGetParamKeyField($GET, 'xAxisField', $fields);
        if(isset($xAxisField['error'])){return $this->json($xAxisField);}

        $yAxisField = GetValidator::checkGetParamKeyField($GET, 'yAxisField', $fields);
        if(isset($yAxisField['error'])){return $this->json($yAxisField);}

        
        // $data = linearHandler($xAxisField, $yAxisField, $products, $dates, $dataBase);
        $queryBuilder = $conn->createQueryBuilder();

        $queryBuilder->select($xAxisField, $yAxisField)->from('Apples', 'a');
        
        if($products[0] != 'all' )
            $queryBuilder->andWhere("a.products IN (:products)")->setParameter('products', $products, Connection::PARAM_STR_ARRAY);
            
        
            if(count($date) == 1){
                $queryBuilder->andWhere("a.date = (:date)")->setParameter('date', $date);
            }else{
                $queryBuilder->andWhere("a.date BETWEEN  :date_1 AND :date_2")->setParameter('date_1', $date[0])
                ->setParameter('date_2', $date[1]);
            }
        
        $respone = $queryBuilder->execute()->fetchAll();
        
        // $jsonResponse = new \Symfony\Component\HttpFoundation\JsonResponse($respone);
        // $jsonResponse->setEncodingOptions(256);
        // return $jsonResponse->send();
        
        return $this->json($respone);
    }
}
