<?php

namespace Review\Model;

final class AffiliateProgram
{

    public string $platform;
    public string $advertiserId;
    public string $publisherId;
    public int $comission;

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
}
