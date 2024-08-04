<?php

namespace Review\Model;

final class AffiliateProgram
{
    public string $name;
    public string $id;
    public string $platform;
    public string $advertiserId;
    public string $publisherId;
    public int|null $comission;

    public function getPlatform()
    {
        return $this->platform;
    }

    public function getAdvertiserId()
    {
        return $this->advertiserId;
    }

    public function getPublisherId()
    {
        return $this->publisherId;
    }

    public function getComission()
    {
        return $this->comission;
    }

    public function setPlatform($platform)
    {
        $this->platform = $platform;
        return $this;
    }

    public function setAdvertiserId($advertiserId)
    {
        $this->advertiserId = $advertiserId;
        return $this;
    }

    public function setPublisherId($publisherId)
    {
        $this->publisherId = $publisherId;
        return $this;
    }

    public function setComission($comission)
    {
        $this->comission = $comission;
        return $this;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param string $id
     *
     * @return self
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
