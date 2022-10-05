<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cet email')]
#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;
  
  #[ORM\Column(length: 180, unique: true)]
  private ?string $email = null;
  
  #[ORM\Column]
  private array $roles = [];
  
  /**
   * @var string The hashed password
   */
  #[ORM\Column]
  private ?string $password = null;

  #[ORM\Column]
  private ?bool $status = null;

  #[ORM\OneToOne(inversedBy: 'user_id', cascade: ['persist', 'remove'])]
  private ?Franchises $franchise = null;

  #[ORM\OneToOne(inversedBy: 'user_id', cascade: ['persist', 'remove'])]
  private ?Structures $structure = null;

  #[ORM\Column(type: 'boolean')]
  private $is_verified = false;
  
  public function getId(): ?int
  {
    return $this->id;
  }
  
  public function getEmail(): ?string
  {
    return $this->email;
  }
  
  public function setEmail(string $email): self
  {
    $this->email = $email;
    
    return $this;
  }
  
  /**
   * A visual identifier that represents this user.
   *
   * @see UserInterface
   */
  public function getUserIdentifier(): string
  {
    return (string)$this->email;
  }
  
  /**
   * @see UserInterface
   */
  public function getRoles(): array
  {
    $roles = $this->roles;
    // guarantee every user at least has ROLE_USER
    $roles[] = 'ROLE_MANAGER';
    
    return array_unique($roles);
  }
  
  public function setRoles(array $roles): self
  {
    $this->roles = $roles;
    
    return $this;
  }
  
  /**
   * @see PasswordAuthenticatedUserInterface
   */
  public function getPassword(): string
  {
    return $this->password;
  }
  
  public function setPassword(string $password): self
  {
    $this->password = $password;
    
    return $this;
  }
  
  /**
   * @see UserInterface
   */
  public function eraseCredentials()
  {
    // If you store any temporary, sensitive data on the user, clear it here
    // $this->plainPassword = null;
  }

  public function isStatus(): ?bool
  {
    return $this->status;
  }
  
  public function setStatus(bool $status): self
  {
    $this->status = $status;
    
    return $this;
  }

  public function getIsVerified(): ?bool
  {
    return $this->is_verified;
  }

  public function setIsVerified(bool $is_verified): self
  {
    $this->is_verified = $is_verified;

    return $this;
  }

  public function getFranchise(): ?Franchises
  {
      return $this->franchise;
  }

  public function setFranchise(?Franchises $franchise): self
  {
      // unset the owning side of the relation if necessary
      if ($franchise === null && $this->franchise !== null) {
          $this->franchise->setUserId(null);
      }

      // set the owning side of the relation if necessary
      if ($franchise !== null && $franchise->getUserId() !== $this) {
          $franchise->setUserId($this);
      }

      $this->franchise = $franchise;

      return $this;
  }

  public function getStructure(): ?Structures
  {
      return $this->structure;
  }

  public function setStructure(?Structures $structure): self
  {
      // unset the owning side of the relation if necessary
      if ($structure === null && $this->structure !== null) {
          $this->structure->setUserId(null);
      }

      // set the owning side of the relation if necessary
      if ($structure !== null && $structure->getUserId() !== $this) {
          $structure->setUserId($this);
      }

      $this->structure = $structure;

      return $this;
  }

  public function getFranchiseId(): ?Franchises
  {
      return $this->franchise;
  }

  public function setFranchiseId(?Franchises $franchise): self
  {
      $this->franchise = $franchise;

      return $this;
  }

  public function getStructureId(): ?Structures
  {
      return $this->structure;
  }

  public function setStructureId(?Structures $structure): self
  {
      $this->structure = $structure;

      return $this;
  }
}
