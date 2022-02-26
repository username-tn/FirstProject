<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("product")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("product")
     */
    private $Name;
    /**
     * @ORM\Column(type="integer", length=10)
     * @Groups("product")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("product")
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("product")
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=SubCategory::class, inversedBy="Category")
     * @Groups("product")
     */
    private $SubCategory;

    /**
     * @ORM\Column(type="integer")
     * @Groups("product")
     */
    private $quantity;

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->SubCategory;
    }

    public function setSubCategory(?SubCategory $SubCategory): self
    {
        $this->SubCategory = $SubCategory;

        return $this;
    }

    public function _ToString()
    {
        return $this->name;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
