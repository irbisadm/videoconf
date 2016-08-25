<?php
/**
 * Created by PhpStorm.
 * User: irbisadm
 * Date: 22/08/16
 * Time: 14:05
 */

namespace Voximplant\VideoConf;
use Doctrine\ORM\EntityManager;
use Voximplant\VideoConf\Data\Portal;
use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request;

class Actions
{
  private $entityManager;

  /**
   * Actions constructor.
   * @param EntityManager $entityManager
   */
  public function __construct($entityManager){
    $this->entityManager = $entityManager;
  }

  public function doAdminPortalLogin($request){
    $portal = $this->entityManager
      ->getRepository('Voximplant\VideoConf\Data\Portal')
      ->findBy(["voxId"=>$request['account_id']]);
    $isNew = false;
    if(count($portal)==0){
      //Get account info
      $client = new Client();
      $htpRequest = new Request('GET', "https://api.voximplant.com/platform_api/GetAccountInfo" .
        "?account_id={$request['account_id']}" .
        "&api_key={$request['api_key']}");
      $api_response = null;
      $promise = $client->sendAsync($htpRequest);
      $response = $promise->wait();
      $content = json_decode($response->getBody()->getContents());
      $portal = new Portal();
      $portal->setVoxId($request['account_id']);
      $portal->setVoxApiKey($request['api_key']);
      $portal->setEmail($content->result->account_email);
      $portal->setEnableNotification(true);
      $this->entityManager->persist($portal);
      $this->entityManager->flush();
      $isNew = true;
    }
    return[
      'response'=>'ok',
      'result'=>[
        'result'    =>  $request['result'],
        'balance'   =>  $request['balance'],
        'account_id'=>  $request['account_id'],
        'is_new'    =>  $isNew
      ]
    ];
  }
}