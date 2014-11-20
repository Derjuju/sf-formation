<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Util\SecureRandomInterface;

/**
 * @ORM\Table(name="sl_players")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PlayerRepository")
 * @UniqueEntity(fields={"email"})
 * @UniqueEntity(fields={"username"})
 */
class Player implements UserInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $username
     *
     * @ORM\Column(length=15, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=15)
     */
    private $username;

    /**
     * @var string $email
     *
     * @ORM\Column(length=60, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=60)
     * @Assert\Email(checkMX=true)
     *
     */
    private $email;

    /**
     * @var string $password
     *
     * @ORM\Column(length=150)
     * @Assert\NotBlank()
     * @Assert\Length(min=4, max=150)
     */
    private $password;

    /**
     * @var string $salt
     *
     * @ORM\Column(length=40)
     */
    private $salt;

    /**
     * @var boolean $isActive
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var boolean $isAdmin
     *
     * @ORM\Column(name="is_admin", type="boolean")
     */
    private $isAdmin;

    /**
     * @var \DateTime $expiresAt
     *
     * @ORM\Column(name="expires_at", type="datetime", nullable=true)
     */
    private $expiresAt;

    private $rawPassword;

    public function __construct()
    {
        $this->isActive  = true;
        $this->isAdmin   = false;
        $this->expiresAt = new \DateTime('+30 days');
    }

    public function setRawPassword($password)
    {
        $this->rawPassword = $password;
    }

    public function getRawPassword()
    {
        return $this->rawPassword;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    public function getRoles()
    {
        return ['ROLE_USER', 'ROLE_ADMIN'];
    }

    public function eraseCredentials()
    {
    }
    
    
    public function generatePassword(PasswordEncoderInterface $encoder, SecureRandomInterface $secureRandom)
    {
        $this->salt = md5($secureRandom->nextBytes(10));
        $this->password = $encoder->encodePassword($this->password, $this->salt);        
    }
    
}
