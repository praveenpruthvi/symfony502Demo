<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted=false;

    /**
     * @ORM\Column(type="integer")
     */
    private $created_by;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_ts;

    /**
     * @ORM\Column(type="integer")
     */
    private $updated_by;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_ts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getCreatedBy(): ?int
    {
        return $this->created_by;
    }

    public function setCreatedBy(int $created_by): self
    {
        $this->created_by = $created_by;

        return $this;
    }

    public function getCreatedTs(): ?\DateTimeInterface
    {
        return $this->created_ts;
    }

    public function setCreatedTs(\DateTimeInterface $created_ts): self
    {
        $this->created_ts = $created_ts;

        return $this;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(int $updated_by): self
    {
        $this->updated_by = $updated_by;

        return $this;
    }

    public function getUpdatedTs(): ?\DateTimeInterface
    {
        return $this->updated_ts;
    }

    public function setUpdatedTs(\DateTimeInterface $updated_ts): self
    {
        $this->updated_ts = $updated_ts;

        return $this;
    }
}
