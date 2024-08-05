<?php

namespace Review\Interface;

interface ElementsInterface
{
    public function get(\Review\Model\Field $field) : string;
}