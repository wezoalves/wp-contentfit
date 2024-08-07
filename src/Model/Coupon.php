<?php

namespace Review\Model;

final class Coupon
{
    public string|null $id;
    public string|null $title;
    public string|null $description;
    public int|null $percentage;
    private Store|null $store = null;  // id CPT Store
    public string|null $affiliatePlatform; // key_program AMAZON, AWIN
    public string|null $promotionId;
    public string|null $code;
    public string|null $iniDate;
    public string|null $endDate;
    public string|null $addDate;
    public string|null $terms;
    public string|null $link; // link wordpress
    public string|null $url; // url to store


    /**
     * Get the value of id
     *
     * @return string|null
     */
    public function getId() : string|null
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
    public function setId(string|null $id) : self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return string|null
     */
    public function getTitle() : string|null
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
    public function setTitle(string|null $title) : self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     *
     * @return string|null
     */
    public function getDescription() : string|null
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
    public function setDescription(string|null $description) : self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of percentage
     *
     * @return int|null
     */
    public function getPercentage() : int|null
    {
        return $this->percentage;
    }

    /**
     * Set the value of percentage
     *
     * @param int|null $percentage
     *
     * @return self
     */
    public function setPercentage(int|null $percentage) : self
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get the value of affiliatePlatform
     *
     * @return string|null
     */
    public function getAffiliatePlatform() : string|null
    {
        return $this->affiliatePlatform;
    }

    /**
     * Set the value of affiliatePlatform
     *
     * @param string|null $affiliatePlatform
     *
     * @return self
     */
    public function setAffiliatePlatform(string|null $affiliatePlatform) : self
    {
        $this->affiliatePlatform = $affiliatePlatform;

        return $this;
    }

    /**
     * Get the value of promotionId
     *
     * @return string|null
     */
    public function getPromotionId() : string|null
    {
        return $this->promotionId;
    }

    /**
     * Set the value of promotionId
     *
     * @param string|null $promotionId
     *
     * @return self
     */
    public function setPromotionId(string|null $promotionId) : self
    {
        $this->promotionId = $promotionId;

        return $this;
    }

    /**
     * Get the value of code
     *
     * @return string|null
     */
    public function getCode() : string|null
    {
        return $this->code;
    }

    /**
     * Get the value of code
     *
     * @return string|null
     */
    public function getCodeSecret() : string|null
    {
        $visible_part = '*****' . substr($this->code, -4); // Exibe os últimos 4 caracteres com asteriscos antes
        return $visible_part;
    }


    /**
     * Set the value of code
     *
     * @param string|null $code
     *
     * @return self
     */
    public function setCode(string|null $code) : self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of iniDate
     *
     * @return string|null
     */
    public function getIniDate() : string|null
    {
        return $this->iniDate;
    }

    /**
     * Set the value of iniDate
     *
     * @param string|null $iniDate
     *
     * @return self
     */
    public function setIniDate(string|null $iniDate) : self
    {
        $this->iniDate = $iniDate;

        return $this;
    }

    /**
     * Get the value of endDate
     *
     * @return string|null
     */
    public function getEndDate($format = null) : string|null
    {
        return $this->convertToDate($this->endDate, $format);
    }

    /**
     * Set the value of endDate
     *
     * @param string|null $endDate
     *
     * @return self
     */
    public function setEndDate(string|null $endDate) : self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get the value of addDate
     *
     * @return string|null
     */
    public function getAddDate() : string|null
    {
        return $this->addDate;
    }

    /**
     * Set the value of addDate
     *
     * @param string|null $addDate
     *
     * @return self
     */
    public function setAddDate(string|null $addDate) : self
    {
        $this->addDate = $addDate;

        return $this;
    }

    /**
     * Get the value of terms
     *
     * @return string|null
     */
    public function getTerms() : string|null
    {
        return $this->terms;
    }

    /**
     * Set the value of terms
     *
     * @param string|null $terms
     *
     * @return self
     */
    public function setTerms(string|null $terms) : self
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * Get the value of link
     *
     * @return string|null
     */
    public function getLink() : string|null
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
    public function setLink(string|null $link) : self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get the value of url
     *
     * @return string|null
     */
    public function getUrl() : string|null
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
    public function setUrl(string|null $url) : self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of store
     *
     * @return Store|null
     */
    public function getStore() : Store|null
    {
        return $this->store;
    }

    /**
     * Set the value of store
     *
     * @param Store|null $store
     *
     * @return self
     */
    public function setStore(Store|null $store) : self
    {
        $this->store = $store;

        return $this;
    }
    private function convertToDate($date, $format = null)
    {
        if (! $format) {
            $format = 'Y/m/d H:i:s';
        }
        $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $date);
        return $datetime ? $datetime->format($format) : '';
    }
}