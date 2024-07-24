<?php

namespace Review\Domain;

use Review\Model\Offer;

/**
 * Class BestOffer
 * 
 * This class is responsible for determining the best offer from a given array of offers. 
 * The best offer is defined as the offer with the lowest price.
 */
final class BestOffer
{
    /**
     * Gets the best offer (the one with the lowest price) from an array of offers.
     * 
     * @param array $arrayOffers An array of offers where each offer is an instance of Offer.
     * @return Offer The offer with the lowest price.
     * 
     * Example Usage:
     * ```php
     * use Review\Domain\BestOffer;
     * 
     * $bestOffer = new BestOffer();
     * $offers = [
     *     new Offer('store1', 1, 100, '100,00', 'url1', 'url_offer1', 10),
     *     new Offer('store2', 2, 200, '200,00', 'url2', 'url_offer2', 20),
     *     new Offer('store3', 3, 50, '50,00', 'url3', 'url_offer3', 5),
     * ];
     * $best = $bestOffer->getBest($offers);
     * 
     * print_r($best); // Output: Offer instance with price 50
     * ```
     */
    public function getBest(array $arrayOffers = []) : Offer
    {
        $initial = new Offer(null, null, PHP_FLOAT_MAX, number_format(PHP_FLOAT_MAX, 2, ',', '.'), null, null, 0);
        return array_reduce($arrayOffers, function (Offer $carry, Offer $item) {
            if ($item->getPrice() < $carry->getPrice()) {
                return $item;
            }
            return $carry;
        }, $initial);
    }
}
