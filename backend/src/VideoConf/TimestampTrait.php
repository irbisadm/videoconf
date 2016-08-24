<?php
/**
 * Created by PhpStorm.
 * User: irbisadm
 * Date: 22/08/16
 * Time: 14:39
 */

namespace Voximplant\VideoConf;

/**
 * Class TimestampTrait - trait for default active/removed and
 * @package Voximplant\VideoConf
 */
trait TimestampTrait
{
  /** @Column(type="boolean",name="is_active") **/
  private $isActive = true;
  /** @Column(type="boolean",name="is_removed") **/
  private $isRemoved = false;
  /** @Column(type="datetime",name="created_at") **/
  private $createdAt;
  /** @Column(type="datetime", nullable = true,name="updated_at") **/
  private $updatedAt;
  /** @PrePersist **/
  public function _onPrePersist(){
    $this->createdAt = new \DateTime("now");
    if(method_exists($this,'onPrePersist'))
      $this->onPrePersist();
  }
  /** @ORM\PreUpdate **/
  public function _onPreUpdate(){
    $this->updatedAt = new \DateTime("now");
    if(method_exists($this,'onPreUpdate'))
      $this->onPreUpdate();
  }

  /**
   * @return mixed
   */
  public function getIsActive(){
    return $this->isActive;
  }

  /**
   * @param mixed $isActive
   */
  public function setIsActive($isActive){
    $this->isActive = $isActive;
  }

  /**
   * @return mixed
   */
  public function getIsRemoved(){
    return $this->isRemoved;
  }

  /**
   * @param mixed $isRemoved
   */
  public function setIsRemoved($isRemoved){
    $this->isRemoved = $isRemoved;
  }

  /**
   * @return mixed
   */
  public function getCreatedAt(){
    return $this->createdAt;
  }

  /**
   * @param mixed $createdAt
   */
  public function setCreatedAt($createdAt){
    $this->createdAt = $createdAt;
  }

  /**
   * @return mixed
   */
  public function getUpdatedAt(){
    return $this->updatedAt;
  }

  /**
   * @param mixed $updatedAt
   */
  public function setUpdatedAt($updatedAt){
    $this->updatedAt = $updatedAt;
  }
}