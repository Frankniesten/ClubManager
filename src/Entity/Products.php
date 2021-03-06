<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 * @Gedmo\Loggable
 * @Vich\Uploadable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Products
{
	use TimestampableEntity;
	use BlameableEntity;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Gedmo\Versioned
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $productID;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $model;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $manufacturer;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Versioned
     */
    private $purchaseDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="review", orphanRemoval=true)
     */
    private $review;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     */
    private $category;

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

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $loan;

    /**
     * @ORM\Column(type="boolean")
     */
    private $uniqueProduct;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identifier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $additionalProperty;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="products")
     */
    private $image;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $url;

    public function __construct()
    {
        $this->review = new ArrayCollection();
        $this->isRelatedTo = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->ownershipInfos = new ArrayCollection();
        $this->image = new ArrayCollection();
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

    public function getPurchaseDate(): ?DateTimeInterface
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(?DateTimeInterface $purchaseDate): self
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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

    public function getLoan(): ?bool
    {
        return $this->loan;
    }

    public function setLoan(?bool $loan): self
    {
        $this->loan = $loan;

        return $this;
    }

    public function getuniqueProduct(): ?bool
    {
        return $this->uniqueProduct;
    }

    public function setuniqueProduct(bool $uniqueProduct): self
    {
        $this->uniqueProduct = $uniqueProduct;

        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(?string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getAdditionalProperty(): ?string
    {
        return $this->additionalProperty;
    }

    public function setAdditionalProperty(?string $additionalProperty): self
    {
        $this->additionalProperty = $additionalProperty;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setProducts($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->contains($image)) {
            $this->image->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getProducts() === $this) {
                $image->setProducts(null);
            }
        }

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
