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
use Voximplant\VideoConf\Data\ServiceUser;

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
    if($this->fallParams($request,['account_id','api_key','result','balance']))
      return ExportableError::WrongIncomParams();
    $portal = $this->entityManager
      ->getRepository('Voximplant\VideoConf\Data\Portal')
      ->findBy(["voxId"=>$request['account_id']]);
    $isNew = false;
    if(count($portal)==0){
      //Get account info
      $client = new Client();
      $httpRequest = new Request('GET', "https://api.voximplant.com/platform_api/GetAccountInfo" .
        "?account_id={$request['account_id']}" .
        "&api_key={$request['api_key']}");
      $api_response = null;
      $promise = $client->sendAsync($httpRequest);
      $response = $promise->wait();
      $content = json_decode($response->getBody()->getContents());
      //check 4 voximplant errors
      if(!empty($content->error))
        return ExportableError::VoxError($content->error);
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

  public function doGetClients($request){
    if($this->fallParams($request,['account_id','session_id','count','offset']))
      return ExportableError::WrongIncomParams();
    $portal = $this->entityManager
      ->getRepository('Voximplant\VideoConf\Data\Portal')
      ->findOneBy(["voxId"=>$request['account_id']]);
    if(is_null($portal))
      return ExportableError::PortalNotFound();
    $httpRequest = new Request('GET',"https://api.voximplant.com/platform_api/GetChildrenAccounts" .
      "?account_id={$request['account_id']}" .
      "&session_id={$request['session_id']}" .
      "&count={$request['count']}" .
      "&offset={$request['offset']}");
    $client = new Client();
    $promise = $client->sendAsync($httpRequest);
    $response = $promise->wait();
    $content = json_decode($response->getBody()->getContents());
    //Check 4 voximplant errors
    if(!empty($content->error))
      return ExportableError::VoxError($content->error);
    $qb = $this->entityManager->createQueryBuilder();
    $qb->select('su')
      ->from('Voximplant\VideoConf\Data\ServiceUser','su')
      ->where($qb->expr()->andX(
        $qb->expr()->eq('su.isRemoved','?1'),
        $qb->expr()->in('su.voxId','?2')
      ))
      ->setParameter(1,false);
    $voxIdKeys = [];
    foreach($content->result as $value){
      $voxIdKeys[] = $value->account_id;
    }
    $qb->setParameter(2,$voxIdKeys);
    /** @var ServiceUser[] $registredUsers */
    $registredUsers = $qb->getQuery()->getResult();
    $registredUsersIdx = [];
    //we have up to 500 users at once. Index is great idea
    foreach ($registredUsers as $value){
      $registredUsersIdx[$value->getVoxId()] = $value;
    }
    $positiveResponse = [
      'response'=>'ok',
      'result'=>[],
      'total_count'=>$content->total_count
    ];
    foreach($content->result as $value){
      if(empty($registredUsersIdx[$value->account_id])){
        //new, not registred users
        $cUser = new ServiceUser();
        $cUser->setVoxId($value->account_id);
        $cUser->setVoxApiKey($value->api_key);
        $cUser->setPortal($portal);
        $cUser->setNotInBase(true);
        $cUser->setVoxAccountName($value->account_name);
        $cUser->setVoxAccountEmail($value->account_email);
      }else{
        //regular users
        /** @var ServiceUser $cUser */
        $cUser = $registredUsersIdx[$value->account_id];
      }

      $positiveResponse['result'][] = [
        'id'            => $cUser->getId(),
        'active'        => $cUser->getIsActive(),
        'account_id'    => $cUser->getVoxId(),
        'created_at'    => $cUser->getCreatedAt(),
        'balance'       => $value->balance,
        'currency'      => $value->currency,
        'account_name'  => $cUser->getVoxAccountName(),
        'account_email' => $cUser->getVoxAccountEmail(),
        'not_in_base'   => $cUser->isNotInBase()
      ];
    }
    return $positiveResponse;
  }

  public function doToggleClientActive($request){
    if($this->fallParams($request,['account_id','session_id','id']))
      return ExportableError::WrongIncomParams();
    $portal = $this->entityManager
      ->getRepository('Voximplant\VideoConf\Data\Portal')
      ->findOneBy(["voxId"=>$request['account_id']]);
    if(is_null($portal))
      return ExportableError::PortalNotFound();
    /** @var ServiceUser $cUser */
    $cUser = $this->entityManager
      ->getRepository('Voximplant\VideoConf\Data\ServiceUser')
      ->findOneBy(["id"=>$request['id']]);
    if(is_null($cUser))
      return ExportableError::ServiceUserNotFound();
    $cUser->setIsActive(!$cUser->getIsActive());
    $this->entityManager->persist($cUser);
    $this->entityManager->flush();
    return [
      'response'=>'ok'
    ];
  }

  public function doEditClient($request){
    if($this->fallParams($request,['account_id','session_id','reg_acc']))
      return ExportableError::WrongIncomParams();
    $portal = $this->entityManager
      ->getRepository('Voximplant\VideoConf\Data\Portal')
      ->findOneBy(["voxId"=>$request['account_id']]);
    if(is_null($portal))
      return ExportableError::PortalNotFound();
    //Need check that ChildAccount exist in VoxImplant
    $httpRequest = new Request('GET',"https://api.voximplant.com/platform_api/GetChildrenAccounts" .
      "?account_id={$request['account_id']}" .
      "&session_id={$request['session_id']}" .
      "&child_account_id={$request['reg_acc']}");
    $client = new Client();
    $promise = $client->sendAsync($httpRequest);
    $response = $promise->wait();
    $content = json_decode($response->getBody()->getContents());
    if(!empty($content->error))
      return ExportableError::VoxError($content->error);
    $cUser = $this->entityManager
      ->getRepository('Voximplant\VideoConf\Data\ServiceUser')
      ->findOneBy(["voxId"=>$request['reg_acc']]);
    if(is_null($cUser))
      $cUser = new ServiceUser();
    $cUser->setVoxAccountEmail($content->result[0]->account_email);
    $cUser->setVoxApiKey($content->result[0]->api_key);
    $cUser->setVoxAccountName($content->result[0]->account_name);
    $cUser->setVoxId($content->result[0]->account_id);
    $cUser->setPortal($portal);
    $this->entityManager->persist($cUser);
    $this->entityManager->flush();
    return [
      'response'=>'ok'
    ];
  }

  public function doPayUser($request){
    if($this->fallParams($request,['account_id','session_id','id','amount']))
      return ExportableError::WrongIncomParams();
    $portal = $this->entityManager
      ->getRepository('Voximplant\VideoConf\Data\Portal')
      ->findOneBy(["voxId"=>$request['account_id']]);
    if(is_null($portal))
      return ExportableError::PortalNotFound();
    /** @var ServiceUser $cUser */
    $cUser = $this->entityManager
      ->getRepository('Voximplant\VideoConf\Data\ServiceUser')
      ->findOneBy(["id"=>$request['id']]);
    if(is_null($cUser))
      return ExportableError::ServiceUserNotFound();
    //Add money to VI user
    $httpRequest = new Request('GET',"https://api.voximplant.com/platform_api/TransferMoneyToChildAccount" .
      "?account_id={$request['account_id']}" .
      "&session_id={$request['session_id']}" .
      "&child_account_id={$cUser->getVoxId()}".
      "&amount={$request['amount']}");
    $client = new Client();
    $promise = $client->sendAsync($httpRequest);
    $response = $promise->wait();
    $content = json_decode($response->getBody()->getContents());
    if(!empty($content->error))
      return ExportableError::VoxError($content->error);
    return [
      'response'=>'ok'
    ];
  }

  public function doCreateUser($request){
    if($this->fallParams($request,[
      'account_id',
      'session_id',
      'first_name',
      'last_name',
      'acc_email',
      'acc_pass',
      'acc_pass_c',
      'acc_mobile',
      'start_balance'
    ]))
      return ExportableError::WrongIncomParams();
    if($request['acc_pass']!=$request['acc_pass_c'])
      return ExportableError::PasswordNotEqual();
    $portal = $this->entityManager
      ->getRepository('Voximplant\VideoConf\Data\Portal')
      ->findOneBy(["voxId"=>$request['account_id']]);
    if(is_null($portal))
      return ExportableError::PortalNotFound();
    $username = str_replace(['@','.'],'-',$request['acc_email']);
    $httpRequest = new Request('GET',"https://api.voximplant.com/platform_api/AddAccount" .
      "?parent_account_id={$request['account_id']}" .
      "&session_id={$request['session_id']}" .
      "&account_name={$username}" .
      "&account_email={$request['acc_email']}" .
      "&account_password={$request['acc_pass']}" .
      "&active=true");
    $client = new Client();
    $promise = $client->sendAsync($httpRequest);
    $response = $promise->wait();
    $content = json_decode($response->getBody()->getContents());
    if(!empty($content->error))
      return ExportableError::VoxError($content->error);
    //TODO: client add to db
    $cUser = new ServiceUser();
    $cUser->setIsActive(true);
    $cUser->setVoxId($content->account_id);
    $cUser->setVoxAccountName($username);
    $cUser->setVoxAccountEmail($request['acc_email']);
    $cUser->setVoxApiKey($content->api_key);
    $cUser->setPortal($portal);
    $cUser->setFirstLogin(true);
    $this->entityManager->persist($cUser);
    $this->entityManager->flush();
    if((int)$request['start_balance']!=0){
      $httpRequest = new Request('GET',"https://api.voximplant.com/platform_api/TransferMoneyToChildAccount" .
        "?account_id={$request['account_id']}" .
        "&session_id={$request['session_id']}" .
        "&child_account_id={$content->account_id}".
        "&amount={$request['start_balance']}");
      $client = new Client();
      $promise = $client->sendAsync($httpRequest);
      $promise->wait();
    }
    return [
      'response'=>'ok'
    ];
  }

  /**
   * Check required params
   * @param $request array incoming request params
   * @param $checkArray array array of required fields
   * @return bool
   */
  private function fallParams($request,$checkArray){
    foreach ($checkArray as $value)
      if(!isset($request[$value]))
        return true;
    return false;
  }
}