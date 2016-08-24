<?php
/**
 * Created by PhpStorm.
 * User: irbisadm
 * Date: 23/08/16
 * Time: 13:44
 */

namespace Voximplant\VideoConf\Data;

use Voximplant\VideoConf\TimestampTrait;

/**
 * Class Conference
 * @package Voximplant\VideoConf\Data
 * @Entity @Table(name="conference")
 */
class Conference
{
  use TimestampTrait;
  /** @Id @Column(type="integer") @GeneratedValue **/
  protected $id;
  /**
   * @ManyToOne(targetEntity="ServiceUser",inversedBy="ownConf")
   * @JoinColumn(name="owner_id", referencedColumnName="id")
   */
  protected $owner;

  /** @OneToMany(targetEntity="Participant", mappedBy="conference") **/
  protected $participants;

  /**
   * @ManyToOne(targetEntity="Portal",inversedBy="portalConferences")
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
  public function getOwner()
  {
    return $this->owner;
  }

  /**
   * @param mixed $owner
   */
  public function setOwner($owner)
  {
    $this->owner = $owner;
  }

  /**
   * @return mixed
   */
  public function getParticipants()
  {
    return $this->participants;
  }

  /**
   * @param mixed $participants
   */
  public function setParticipants($participants)
  {
    $this->participants = $participants;
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