<?php

namespace Review\Model;

final class Store
{
    private string|null $id = null;
    private string|null $keyCpt = null;
    private \Review\Model\SimpleType|null $type = null;
    private string|null $description = null;
    private string|null $title = null;
    private string|null $content = null;
    private string|null $link = null;
    private string|null $logo = null;
    private string|null $logoSvg = null;
    private string|null $domain = null;
    private string|null $url = null;
    private string|null $email = null;
    private string|null $raShortName = null;
    private string|null $raStoreId = null;
    private string|null $raScore = null;
    private array|null $affiliatePrograms = null;


    public function __construct(

        string $id = null,
        string $keyCpt = null,
        \Review\Model\SimpleType|null $type = null,
        string $description = null,
        string $title = null,
        string $content = null,
        string $link = null,
        string $logo = null,
        string $logoSvg = null,
        string $domain = null,
        string $url = null,
        string $email = null,
        string $raShortName = null,
        string $raStoreId = null,
        string $raScore = null,
        array $affiliatePrograms = [],
    ) {
        $this->id = $id;
        $this->keyCpt = $keyCpt;
        $this->type = $type;
        $this->description = $description;
        $this->title = $title;
        $this->content = $content;
        $this->link = $link;
        $this->logo = $logo;
        $this->logoSvg = $logoSvg;
        $this->domain = $domain;
        $this->url = $url;
        $this->email = $email;
        $this->raShortName = $raShortName;
        $this->raStoreId = $raStoreId;
        $this->raScore = $raScore;
        $this->affiliatePrograms = $affiliatePrograms;
    }


    /**
     * Get the value of affiliatePrograms
     *
     * @return array|null
     */
    public function getAffiliatePrograms(): array|null
    {
        return $this->affiliatePrograms;
    }

    /**
     * Set the value of affiliatePrograms
     *
     * @param array|null $affiliatePrograms
     *
     * @return self
     */
    public function setAffiliatePrograms(array|null $affiliatePrograms): self
    {
        $this->affiliatePrograms = $affiliatePrograms;

        return $this;
    }

    /**
     * Get the value of raScore
     *
     * @return string|null
     */
    public function getRaScore(): string|null
    {
        return $this->raScore;
    }

    /**
     * Set the value of raScore
     *
     * @param string|null $raScore
     *
     * @return self
     */
    public function setRaScore(string|null $raScore): self
    {
        $this->raScore = $raScore;

        return $this;
    }

    /**
     * Get the value of raStoreId
     *
     * @return string|null
     */
    public function getRaStoreId(): string|null
    {
        return $this->raStoreId;
    }

    /**
     * Set the value of raStoreId
     *
     * @param string|null $raStoreId
     *
     * @return self
     */
    public function setRaStoreId(string|null $raStoreId): self
    {
        $this->raStoreId = $raStoreId;

        return $this;
    }

    /**
     * Get the value of raShortName
     *
     * @return string|null
     */
    public function getRaShortName(): string|null
    {
        return $this->raShortName;
    }

    /**
     * Set the value of raShortName
     *
     * @param string|null $raShortName
     *
     * @return self
     */
    public function setRaShortName(string|null $raShortName): self
    {
        $this->raShortName = $raShortName;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return string|null
     */
    public function getEmail(): string|null
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param string|null $email
     *
     * @return self
     */
    public function setEmail(string|null $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of url
     *
     * @return string|null
     */
    public function getUrl(): string|null
    {
        return $this->url;
    }

    /**
     * Set the value of url
     *
     * @param string|null $url
     *
     * @return self
     */
    public function setUrl(string|null $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of domain
     *
     * @return string|null
     */
    public function getDomain(): string|null
    {
        return $this->domain;
    }

    /**
     * Set the value of domain
     *
     * @param string|null $domain
     *
     * @return self
     */
    public function setDomain(string|null $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get the value of logoSvg
     *
     * @return string|null
     */
    public function getLogoSvg(): string|null
    {
        return $this->logoSvg;
    }

    /**
     * Set the value of logoSvg
     *
     * @param string|null $logoSvg
     *
     * @return self
     */
    public function setLogoSvg(string|null $logoSvg): self
    {
        $this->logoSvg = $logoSvg;

        return $this;
    }

    /**
     * Get the value of logo
     *
     * @return string|null
     */
    public function getLogo(): string|null
    {
        return $this->logo;
    }

    /**
     * Set the value of logo
     *
     * @param string|null $logo
     *
     * @return self
     */
    public function setLogo(string|null $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get the value of link
     *
     * @return string|null
     */
    public function getLink(): string|null
    {
        return $this->link;
    }

    /**
     * Set the value of link
     *
     * @param string|null $link
     *
     * @return self
     */
    public function setLink(string|null $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get the value of content
     *
     * @return string|null
     */
    public function getContent(): string|null
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @param string|null $content
     *
     * @return self
     */
    public function setContent(string|null $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return string|null
     */
    public function getTitle(): string|null
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param string|null $title
     *
     * @return self
     */
    public function setTitle(string|null $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     *
     * @return string|null
     */
    public function getDescription(): string|null
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param string|null $description
     *
     * @return self
     */
    public function setDescription(string|null $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of type
     *
     * @return \Review\Model\SimpleType|null
     */
    public function getType(): \Review\Model\SimpleType|null
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param \Review\Model\SimpleType|null $type
     *
     * @return self
     */
    public function setType(\Review\Model\SimpleType|null $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of keyCpt
     *
     * @return string|null
     */
    public function getKeyCpt(): string|null
    {
        return $this->keyCpt;
    }

    /**
     * Set the value of keyCpt
     *
     * @param string|null $keyCpt
     *
     * @return self
     */
    public function setKeyCpt(string|null $keyCpt): self
    {
        $this->keyCpt = $keyCpt;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return string|null
     */
    public function getId(): string|null
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param string|null $id
     *
     * @return self
     */
    public function setId(string|null $id): self
    {
        $this->id = $id;

        return $this;
    }
}
