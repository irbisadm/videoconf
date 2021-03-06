<?php
/**
 * Created by PhpStorm.
 * User: irbisadm
 * Date: 23/08/16
 * Time: 13:42
 */

namespace Voximplant\VideoConf\Data;

use Doctrine\Common\Collections\ArrayCollection;
use Voximplant\VideoConf\TimestampTrait;

/**
 * Class ServiceUser
 * @package Voximplant\VideoConf\Data
 * @Entity @Table(name="service_user")
 * @HasLifecycleCallbacks
 */
class ServiceUser
{
  use TimestampTrait;
  /** @Id @Column(type="integer") @GeneratedValue **/
  protected $id;

  /** @Column(type="string",name="vox_id") **/
  protected $voxId;

  /** @Column(type="string",name="vox_api_key") **/
  protected $voxApiKey;

  /** @Column(type="string",name="vox_account_email") **/
  protected $voxAccountEmail;

  /** @Column(type="string",name="vox_account_name") **/
  protected $voxAccountName;

  /** @Column(type="boolean",name="first_login") **/
  protected $firstLogin = true;

  /** @OneToMany(targetEntity="Conference", mappedBy="owner") **/
  protected $ownConf;

  protected $notInBase = false;

  /**
   * ServiceUser constructor.
   */
  public function __construct(){
    $this->ownConf = new ArrayCollection();
  }

  /**
   * @ManyToOne(targetEntity="Portal",inversedBy="portalServiceUsers")
   * @JoinColumn(name="portal_id", referencedColumnName="id")
   */
  protected $portal;

  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
   * @return mixed
   */
  public function getVoxId()
  {
    return $this->voxId;
  }

  /**
   * @param mixed $voxId
   */
  public function setVoxId($voxId)
  {
    $this->voxId = $voxId;
  }

  /**
   * @return mixed
   */
  public function getVoxApiKey()
  {
    return $this->voxApiKey;
  }

  /**
   * @param mixed $voxApiKey
   */
  public function setVoxApiKey($voxApiKey)
  {
    $this->voxApiKey = $voxApiKey;
  }

  /**
   * @return mixed
   */
  public function getOwnConf()
  {
    return $this->ownConf;
  }

  /**
   * @param mixed $ownConf
   */
  public function setOwnConf($ownConf)
  {
    $this->ownConf = $ownConf;
  }

  /**
   * @return mixed
   */
  public function getPortal()
  {
    return $this->portal;
  }

  /**
   * @param mixed $portal
   */
  public function setPortal($portal)
  {
    $this->portal = $portal;
  }

  /**
   * @return mixed
   */
  public function getFirstLogin()
  {
    return $this->firstLogin;
  }

  /**
   * @param mixed $firstLogin
   */
  public function setFirstLogin($firstLogin)
  {
    $this->firstLogin = $firstLogin;
  }

  /**
   * @return boolean
   */
  public function isNotInBase()
  {
    return $this->notInBase;
  }

  /**
   * @param boolean $notInBase
   */
  public function setNotInBase(bool $notInBase)
  {
    $this->notInBase = $notInBase;
  }

  /**
   * @return mixed
   */
  public function getVoxAccountEmail()
  {
    return $this->voxAccountEmail;
  }

  /**
   * @param mixed $voxAccountEmail
   */
  public function setVoxAccountEmail($voxAccountEmail)
  {
    $this->voxAccountEmail = $voxAccountEmail;
  }

  /**
   * @return mixed
   */
  public function getVoxAccountName()
  {
    return $this->voxAccountName;
  }

  /**
   * @param mixed $voxAccountName
   */
  public function setVoxAccountName($voxAccountName)
  {
    $this->voxAccountName = $voxAccountName;
  }



}