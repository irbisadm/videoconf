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
      $portal = new Portal();
      $portal->setVoxId($request['account_id']);
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