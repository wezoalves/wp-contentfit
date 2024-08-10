<?php

/**
 * Summary of namespace Review\Affiliate
 * https://v2.afilio.com.br/Manual/manuais-v2.html
 */

namespace Review\Affiliate;

final class Afilio implements \Review\Interface\ProgramInterface
{
    public string|null $affiliateId = null;
    public string|null $advertiserId = null;
    public string|null $source = null;
    private string|null $url = "http://v2.afilio.com.br/api/deeplink.php?token=WWHUu3169105&affid={{affiliateId}}&progid={{advertiserId}}&bantitle=deeplink&bandesc=deeplink&siteid=17271&desturl={{url_destination}}";


    public function __construct(string $advertiserId = null, string $affiliateId = null, string $source = null)
    {
        if ($advertiserId) :
            $this->advertiserId = $advertiserId;
        endif;

        if ($affiliateId) :
            $this->affiliateId = $affiliateId;
        endif;

        if ($source) :
            $this->source = $source;
        endif;
    }

    public function getUrl(string $url = null) : string
    {

        $url = \Review\Utils\Url::clean($url);

        return strtr($this->url, [
            "{{advertiserId}}" => $this->advertiserId,
            "{{affiliateId}}" => $this->affiliateId,
            "{{url_destination}}" => urlencode($url)
        ]);
    }

}
