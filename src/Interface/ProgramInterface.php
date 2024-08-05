<?php

namespace Review\Interface;

interface ProgramInterface
{
    public function __construct();

    public function getUrl() : string;
}