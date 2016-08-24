<?php
/**
 * Created by PhpStorm.
 * User: irbisadm
 * Date: 23/08/16
 * Time: 14:12
 */

namespace Voximplant\VideoConf\Data;
use Voximplant\VideoConf\TimestampTrait;

/**
 * Class UserConf
 * @package Voximplant\VideoConf\Data
 * @Entity @Table(name="participant")
 * @HasLifecycleCallbacks
 */
class Participant
{
  use TimestampTrait;
  /** @Id @Column(type="integer") @GeneratedValue **/
  protected $id;

  /** @Column(type="boolean",name="online") **/
  protected $online;

  /** @Column(type="string",name="$vox_login") **/
  protected $voxLogin;

  /** @Column(type="string",name="$vox_password") **/
  protected $voxPassword;

  /** @Column(type="boolean",name="vox_user_exist") **/
  protected $voxUserExist;

  /**
   * @ManyToOne(targetEntity="Conference", inversedBy="participants")
   * @JoinColumn(name="conference_id", referencedColumnName="id")
   */
  protected $conference;

  /** @Column(type="string",name="email") **/
  protected $email;

  /** @Column(type="string",name="pstn") **/
  protected $pstn;

  /** @Column(type="string",name="title") **/
  protected $title;

  /** @Column(type="string",name="pstn_pin") **/
  protected $pstnPin;

  /**
   * @ManyToOne(targetEntity="Portal",inversedBy="portalParticipants")
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
  public function getOnline()
  {
    return $this->online;
  }

  /**
   * @param mixed $online
   */
  public function setOnline($online)
  {
    $this->online = $online;
  }

  /**
   * @return mixed
   */
  public function getVoxLogin()
  {
    return $this->voxLogin;
  }

  /**
   * @param mixed $voxLogin
   */
  public function setVoxLogin($voxLogin)
  {
    $this->voxLogin = $voxLogin;
  }

  /**
   * @return mixed
   */
  public function getVoxPassword()
  {
    return $this->voxPassword;
  }

  /**
   * @param mixed $voxPassword
   */
  public function setVoxPassword($voxPassword)
  {
    $this->voxPassword = $voxPassword;
  }

  /**
   * @return mixed
   */
  public function getVoxUserExist()
  {
    return $this->voxUserExist;
  }

  /**
   * @param mixed $voxUserExist
   */
  public function setVoxUserExist($voxUserExist)
  {
    $this->voxUserExist = $voxUserExist;
  }

  /**
   * @return mixed
   */
  public function getConference()
  {
    return $this->conference;
  }

  /**
   * @param mixed $conference
   */
  public function setConference($conference)
  {
    $this->conference = $conference;
  }

  /**
   * @return mixed
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * @param mixed $email
   */
  public function setEmail($email)
  {
    $this->email = $email;
  }

  /**
   * @return mixed
   */
  public function getPstn()
  {
    return $this->pstn;
  }

  /**
   * @param mixed $pstn
   */
  public function setPstn($pstn)
  {
    $this->pstn = $pstn;
  }

  /**
   * @return mixed
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * @param mixed $title
   */
  public function setTitle($title)
  {
    $this->title = $title;
  }

  /**
   * @return mixed
   */
  public function getPstnPin()
  {
    return $this->pstnPin;
  }

  /**
   * @param mixed $pstnPin
   */
  public function setPstnPin($pstnPin)
  {
    $this->pstnPin = $pstnPin;
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