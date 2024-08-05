<?php

namespace Review\Interface;

interface ApiInterface
{
    function getFieldValidator() : string;
    public function create(\WP_REST_Request $request);
    public function get(\WP_REST_Request $request);
    public function list(\WP_REST_Request $request);
    public function delete(\WP_REST_Request $request);
    public function RestApiInit();
}