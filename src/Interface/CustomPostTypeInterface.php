<?php

namespace Review\Interface;

interface CustomPostTypeInterface
{
    public static function getKey(): string;
    public static function init(): void;
    public static function add_meta_boxes(): void;
}