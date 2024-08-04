<?php

namespace Review\Model;

use Review\Model\TenisType;
use Review\Model\Offer;
use Review\Model\Store;
final class Tenis
{
    private string|null $id = null;
    private string|null $keyCpt = null;
    private TenisType|null $type = null; // Alterado para array
    private string|null $image = null;
    private array|null $gallery = null;
    private string|null $description = null;
    private string|null $resume = null;
    private array|null $classification = null;
    private array|null $classificationExplained = null;
    private string|null $characteristics = null;
    private string|null $benefits = null;
    private float $priceRegular = 0.0;
    private Offer|null $offerBest = null;
    private array|null $offers = null;
    private Store|null $brand = null;
    private string|null $title = null;
    private string|null $content = null;
    private string|null $link = null;

    public function __construct(
        string $id,
        string $keyCpt,
        TenisType|null $type, // Alterado para array
        string $image,
        array $gallery,
        string $description,
        string $resume,
        array $classification,
        array $classificationExplained,
        string $characteristics,
        string $benefits,
        float $priceRegular,
        Offer $offerBest,
        array $offers,
        Store $brand,
        string $title,
        string $content,
        string $link
    ) {
        $this->id = $id;
        $this->keyCpt = $keyCpt;
        $this->type = $type;
        $this->image = $image;
        $this->gallery = $gallery;
        $this->description = $description;
        $this->resume = $resume;
        $this->classification = $classification;
        $this->classificationExplained = $classificationExplained;
        $this->characteristics = $characteristics;
        $this->benefits = $benefits;
        $this->priceRegular = $priceRegular;
        $this->offerBest = $offerBest;
        $this->offers = $offers;
        $this->brand = $brand;
        $this->title = $title;
        $this->content = $content;
        $this->link = $link;
    }


    // Getters
    public function getId() : ?string
    {
        return $this->id;
    }

    public function getKeyCpt() : ?string
    {
        return $this->keyCpt;
    }

    public function getType() : ?TenisType
    {
        return $this->type;
    }

    public function getImage() : ?string
    {
        return $this->image;
    }

    public function getGallery() : ?array
    {
        return $this->gallery;
    }

    public function getDescription() : ?string
    {
        return $this->description;
    }
    public function getResume() : ?string
    {
        return $this->resume;
    }

    public function getClassification() : ?array
    {
        return $this->classification;
    }

    public function getClassificationExplained() : ?array
    {
        return $this->classificationExplained;
    }

    public function getCharacteristics() : ?string
    {
        return $this->characteristics;
    }

    public function getBenefits() : ?string
    {
        return $this->benefits;
    }

    public function getPriceRegular() : float
    {
        return $this->priceRegular;
    }

    public function getOfferBest() : ?Offer
    {
        return $this->offerBest;
    }

    public function getOffers() : ?array
    {
        return $this->offers;
    }

    public function getBrand() : ?Store
    {
        return $this->brand;
    }

    public function getTitle() : ?string
    {
        return $this->title;
    }

    public function getContent() : ?string
    {
        return $this->content;
    }

    public function getLink() : ?string
    {
        return $this->link;
    }

    // Setters
    public function setId(?string $id) : self
    {
        $this->id = $id;
        return $this;
    }

    public function setKeyCpt(?string $keyCpt) : self
    {
        $this->keyCpt = $keyCpt;
        return $this;
    }

    public function setType(?TenisType $type) : self
    {
        $this->type = $type;
        return $this;
    }

    public function setImage(?string $image) : self
    {
        $this->image = $image;
        return $this;
    }

    public function setGallery(?array $gallery) : self
    {
        $this->gallery = $gallery;
        return $this;
    }

    public function setDescription(?string $description) : self
    {
        $this->description = $description;
        return $this;
    }
    public function setResume(?string $resume) : self
    {
        $this->resume = $resume;
        return $this;
    }
    public function setClassification(?array $classification) : self
    {
        $this->classification = $classification;
        return $this;
    }

    public function setClassificationExplained(?array $classificationExplained) : self
    {
        $this->classificationExplained = $classificationExplained;
        return $this;
    }

    public function setCharacteristics(?string $characteristics) : self
    {
        $this->characteristics = $characteristics;
        return $this;
    }

    public function setBenefits(?string $benefits) : self
    {
        $this->benefits = $benefits;
        return $this;
    }

    public function setPriceRegular(float $priceRegular) : self
    {
        $this->priceRegular = $priceRegular;
        return $this;
    }

    public function setOfferBest(?Offer $offerBest) : self
    {
        $this->offerBest = $offerBest;
        return $this;
    }

    public function setOffers(?array $offers) : self
    {
        $this->offers = $offers;
        return $this;
    }

    public function setBrand(?Store $brand) : self
    {
        $this->brand = $brand;
        return $this;
    }

    public function setTitle(?string $title) : self
    {
        $this->title = $title;
        return $this;
    }

    public function setContent(?string $content) : self
    {
        $this->content = $content;
        return $this;
    }

    public function setLink(?string $link) : self
    {
        $this->link = $link;
        return $this;
    }
}
