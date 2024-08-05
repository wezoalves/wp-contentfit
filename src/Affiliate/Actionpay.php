<?php

namespace Review\Affiliate;

final class Actionpay implements \Review\Interface\ProgramInterface
{
    public string|null $affiliateId = null;
    public string|null $advertiserId = null;
    public string|null $source = null;
    private string $url = 'http://apretailer.com.br/click/{{advertiserId}}/{{affiliateId}}/{{param_source}}/{{param_source}}/url={{url_destination}}';

    
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
