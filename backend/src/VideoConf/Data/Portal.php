<?php
/**
 * Created by PhpStorm.
 * User: irbisadm
 * Date: 24/08/16
 * Time: 14:45
 */

namespace Voximplant\VideoConf\Data;

use Voximplant\VideoConf\TimestampTrait;

/**
 * Class Portal
 * @package Voximplant\VideoConf\Data
 * @Entity @Table(name="portal")
 * @HasLifecycleCallbacks
 */
class Portal
{
  use TimestampTrait;
  /** @Id @Column(type="integer") @GeneratedValue **/
  protected $id;

  /** @Column(type="string",name="title") **/
  protected $title    = "Default title";

  /** @Column(type="string",name="logo_path") **/
  protected $logoPath = "http://dummyimage.com/200x60/000/fff.png";

  /** @Column(type="string",name="vox_id") **/
  protected $voxId;

  /** @OneToMany(targetEntity="Participant", mappedBy="portal") **/
  protected $portalParticipants;

  /** @OneToMany(targetEntity="ServiceUser", mappedBy="portal") **/
  protected $portalServiceUsers;

  /** @OneToMany(targetEntity="Conference", mappedBy="portal") **/
  protected $portalConferences;

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
  public function getLogoPath()
  {
    return $this->logoPath;
  }

  /**
   * @param mixed $logoPath
   */
  public function setLogoPath($logoPath)
  {
    $this->logoPath = $logoPath;
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
  public function getPortalParticipants()
  {
    return $this->portalParticipants;
  }

  /**
   * @param mixed $portalParticipants
   */
  public function setPortalParticipants($portalParticipants)
  {
    $this->portalParticipants = $portalParticipants;
  }

  /**
   * @return mixed
   */
  public function getPortalServiceUsers()
  {
    return $this->portalServiceUsers;
  }

  /**
   * @param mixed $portalServiceUsers
   */
  public function setPortalServiceUsers($portalServiceUsers)
  {
    $this->portalServiceUsers = $portalServiceUsers;
  }

  /**
   * @return mixed
   */
  public function getPortalConferences()
  {
    return $this->portalConferences;
  }

  /**
   * @param mixed $portalConferences
   */
  public function setPortalConferences($portalConferences)
  {
    $this->portalConferences = $portalConferences;
  }
}