<?php

namespace App\Controller;

use Validator\GetValidator;

use App\Repository\ApplesRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExchangeController extends AbstractController
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
     * @Route("/api/exchange", name="exchange")
     */
    public function index(ApplesRepository $applesRepository, Request $request): Response
    {
        $GET = $request->query->all();
        
        $product = GetValidator::checkGetParamOneProduct($GET);
        if(isset($product['error'])){return $this->json($product);}

        $date = GetValidator::checkGetParamDate($GET);
        if(isset($date['error'])){return $this->json($date);}

        $respone = $applesRepository->getExchange($product, $date);
        
        // return $this->json($respone);

        $data = [];
        foreach($respone as $row){

            if (end($data)){

                if (end($data)['time'] == $row['date']){
                    
                    //добавления старотового значения цены
                        if(strtotime(end($data)['start_time']) > strtotime($row['time'])){
                            end($data)['start_time'] = $row['time'];
                            end($data)['start'] = $row['price'];
                        }
                    
                    //добавления конечного значения цены
                        if(strtotime(end($data)['end_time']) < strtotime($row['time'])){
                            $data[count($data) - 1]['end_time'] = $row['time'];
                            $data[count($data) - 1]['end'] = $row['price'];
                        }

                    //добавления минимального значения цены
                        if(end($data)['min'] > $row['price']){
                            $data[count($data) - 1]['min'] = $row['price'];
                        }

                    //добавления максимального значения цены
                        if(end($data)['max'] < $row['price']){
                            $data[count($data) - 1]['max'] = $row['price'];
                        }

                }else{
                    
                    $this->createNewArray($data, $row);

                }      

            }else{

                $this->createNewArray($data, $row);  
                
            } 
        }

        return $this->json([
            'message' => 'Returned',
            'data' => $data,
        ]);

    }

    private function createNewArray(array &$data, array $row){

        array_push($data, array(
            'time'=>$row['date'],
            'start_time'=>$row['time'],
            'end_time'=>$row['time'],
            'start'=>$row['price'],
            'max'=>$row['price'],
            'min'=>$row['price'],
            'end'=>$row['price'],
            
        ));
    }
}
