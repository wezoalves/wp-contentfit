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

        $base = parse_url($url);

        $query_str = parse_url($url, PHP_URL_QUERY);

        $query_params = [];

        if ($query_str) {
            parse_str($query_str, $query_params);
        }

        unset(
            $query_params['_encoding'],
            $query_params['bbn'],
            $query_params['camp'],
            $query_params['creative'],
            $query_params['linkCode'],
            $query_params['linkId'],
            $query_params['pd_rd_i'],
            $query_params['pd_rd_r'],
            $query_params['pd_rd_w'],
            $query_params['pd_rd_wg'],
            $query_params['pf_rd_i'],
            $query_params['pf_rd_m'],
            $query_params['pf_rd_p'],
            $query_params['pf_rd_r'],
            $query_params['pf_rd_s'],
            $query_params['pf_rd_t'],
            $query_params['psc'],
            $query_params['ref_'],
            $query_params['ref'],
            $query_params['refRID'],
            $query_params['tag'],
            $query_params['utm_campaign'],
            $query_params['utm_content'],
            $query_params['utm_medium'],
            $query_params['utm_source'],
            $query_params['utm_term'],
        );

        $query_params['_encoding'] = 'UTF8';
        $query_params['language'] = 'pt_BR';

        ksort($query_params);

        $query_params['tag'] = $this->affiliateId;

        $path = $base['path'] ?? null;
        $host = $base['host'] ?? null;
        $scheme = $base['scheme'] ?? 'https';
        $urlBase = $scheme . '://' . $host . $path;

        $urlBase = $urlBase . '?' . http_build_query($query_params);


        return $urlBase;
    }

}
