<?php

namespace Review\Model;

final class Offer
{
    private $store;
    private $storeId;
    private $price;
    private $priceFormated;
    private $url;
    private $urlOffer;
    private $discount;

    public function __construct($store = null, $storeId = null, $price = null, $priceFormated = null, $url = null, $urlOffer = null, $discount = null)
    {
        if ($store) :
            $this->store = $store;
        endif;
        if ($storeId) :
            $this->storeId = $storeId;
        endif;
        if ($price) :
            $this->price = $price;
        endif;
        if ($priceFormated) :
            $this->priceFormated = $priceFormated;
        endif;
        if ($url) :
            $this->url = $url;
        endif;
        if ($urlOffer) :
            $this->urlOffer = $urlOffer;
        endif;
        if ($discount) :
            $this->discount = $discount;
        endif;
    }

    public function getStore()
    {
        return $this->store;
    }

    public function getStoreId()
    {
        return $this->storeId;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getPriceFormated()
    {
        return $this->priceFormated;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getUrlOffer()
    {
        return $this->urlOffer;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function setStore($store)
    {
        $this->store = $store;
        return $this;
    }

    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
        return $this;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function setPriceFormated($priceFormated)
    {
        $this->priceFormated = $priceFormated;
        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function setUrlOffer($urlOffer)
    {
        $this->urlOffer = $urlOffer;
        return $this;
    }

    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }
}
