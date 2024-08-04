<?php

namespace Review\Domain;

use Review\Repository\Store;
use Review\Model\AffiliateProgram;
use Exception;

/**
 * Class AffiliateOffer
 * 
 * This class is responsible for handling the logic related to generating affiliate URLs based on store ID and other parameters.
 */
final class AffiliateOffer
{
    public ?string $url = null;
    public ?int $storeId = null;
    public ?string $source = null;

    /**
     * Constructor for AffiliateOffer.
     * 
     * @param string|null $url The base URL for the offer.
     * @param int|null $storeId The ID of the store.
     * @param string|null $source The source parameter for tracking.
     */
    public function __construct(?string $url = null, ?int $storeId = null, ?string $source = null)
    {
        $this->url = $url;
        $this->storeId = $storeId;
        $this->source = $source;
    }

    /**
     * Generates the affiliate URL based on the store ID and other parameters.
     * 
     * @return string The generated affiliate URL.
     */
    public function getUrl() : string
    {
        $url = $this->url;
        $storeProgram = (new Store())->getById($this->storeId);

        if (!empty($storeProgram->getAffiliatePrograms())) {

            $bestProgram = $this->getBestProgram($storeProgram->getAffiliatePrograms());

            // Construct the URL using the best affiliate program
            if ($bestProgram->getPlatform()) {
                $platformKey = $bestProgram->getPlatform();
                $className = "Review\\Affiliate\\" . ucwords(strtolower(trim($platformKey)));

                if (class_exists($className)) {
                    $url = (new $className($bestProgram->getAdvertiserId(), $bestProgram->getPublisherId(), $this->source))->getUrl($url);
                }
            }
        }

        return $url;
    }

    /**
     * Selects the best affiliate program based on the highest commission.
     * 
     * @param array $programs The list of affiliate programs.
     * @return AffiliateProgram The best affiliate program.
     * @throws Exception If no valid affiliate program is found.
     */
    private function getBestProgram(array $programs) : AffiliateProgram|null
    {
        $bestProgram = array_reduce($programs, function ($carry, $item) {
            if (!$carry || intval($item->getComission()) > intval($carry->getComission())) {
                return $item;
            }
            return $carry;
        });

        if (!$bestProgram) {
            return null;
        }

        return $bestProgram;
    }
}
