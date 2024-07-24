<?php

namespace Review\Affiliate;

final class Socialsoul
{
    public string|null $affiliateId = null;
    public string|null $advertiserId = null;
    public string|null $source = null;
    private string $url = 'https://redir.lomadee.com/v2/deeplink?sourceId={{affiliateId}}&url={{url_destination}}&mdasc={{param_source}}';

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

        return strtr($this->url, [
            "{{advertiserId}}" => $this->advertiserId,
            "{{affiliateId}}" => $this->affiliateId,
            "{{param_source}}" => $this->source,
            "{{url_destination}}" => $url
        ]);
    }

}
