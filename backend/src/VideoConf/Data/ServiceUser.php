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

  /** @OneToMany(targetEntity="Conference", mappedBy="owner") **/
  protected $ownConf;

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
}