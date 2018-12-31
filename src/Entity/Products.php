<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 */
class Products
{
	use TimestampableEntity;
	
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productID;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $model;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $manufacturer;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $purchaseDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="review")
     */
    private $review;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="products")
     */
    private $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Products", inversedBy="products")
     */
    private $isRelatedTo;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Products", mappedBy="isRelatedTo")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OwnershipInfo", mappedBy="typeofGood", orphanRemoval=true)
     */
    private $ownershipInfos;

    public function __construct()
    {
        $this->review = new ArrayCollection();
        $this->isRelatedTo = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->ownershipInfos = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProductID(): ?string
    {
        return $this->productID;
    }

    public function setProductID(?string $productID): self
    {
        $this->productID = $productID;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(?\DateTimeInterface $purchaseDate): self
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReview(): Collection
    {
        return $this->review;
    }

    public function addReview(Review $review): self
    {
        if (!$this->review->contains($review)) {
            $this->review[] = $review;
            $review->setReview($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->review->contains($review)) {
            $this->review->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getReview() === $this) {
                $review->setReview(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getIsRelatedTo(): Collection
    {
        return $this->isRelatedTo;
    }

    public function addIsRelatedTo(self $isRelatedTo): self
    {
        if (!$this->isRelatedTo->contains($isRelatedTo)) {
            $this->isRelatedTo[] = $isRelatedTo;
        }

        return $this;
    }

    public function removeIsRelatedTo(self $isRelatedTo): self
    {
        if ($this->isRelatedTo->contains($isRelatedTo)) {
            $this->isRelatedTo->removeElement($isRelatedTo);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(self $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addIsRelatedTo($this);
        }

        return $this;
    }

    public function removeProduct(self $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            $product->removeIsRelatedTo($this);
        }

        return $this;
    }

    /**
     * @return Collection|OwnershipInfo[]
     */
    public function getOwnershipInfos(): Collection
    {
        return $this->ownershipInfos;
    }

    public function addOwnershipInfo(OwnershipInfo $ownershipInfo): self
    {
        if (!$this->ownershipInfos->contains($ownershipInfo)) {
            $this->ownershipInfos[] = $ownershipInfo;
            $ownershipInfo->setTypeofGood($this);
        }

        return $this;
    }

    public function removeOwnershipInfo(OwnershipInfo $ownershipInfo): self
    {
        if ($this->ownershipInfos->contains($ownershipInfo)) {
            $this->ownershipInfos->removeElement($ownershipInfo);
            // set the owning side to null (unless already changed)
            if ($ownershipInfo->getTypeofGood() === $this) {
                $ownershipInfo->setTypeofGood(null);
            }
        }

        return $this;
    }
}
