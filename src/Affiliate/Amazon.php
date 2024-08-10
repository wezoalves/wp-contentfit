<?php

namespace Review\Affiliate;

final class Amazon implements \Review\Interface\ProgramInterface
{
    public string|null $affiliateId = null;
    public string|null $advertiserId = null;
    public string|null $source = null;
    private string|null $url = null;


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
        
        $url = \Review\Utils\Url::clean($url, [
            '_encoding',
            'bbn',
            'camp',
            'creative',
            'gclid',
            'linkCode',
            'linkId',
            'pd_rd_i',
            'pd_rd_r',
            'pd_rd_w',
            'pd_rd_wg',
            'pf_rd_i',
            'pf_rd_m',
            'pf_rd_p',
            'pf_rd_r',
            'pf_rd_s',
            'pf_rd_t',
            'psc',
            'ref_',
            'ref',
            'refRID',
            'tag',
            'utm_campaign',
            'utm_content',
            'utm_medium',
            'utm_source',
            'utm_term',
        ]);

        $url = \Review\Utils\Url::add($url, [
            "tag" => $this->affiliateId,
        ]);

        return $url;
    }

}
