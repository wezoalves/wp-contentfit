<?php

namespace Review\Interface;

interface RepositoryInterface
{

    public function getById(int $id);
    public function createModel($data);
}