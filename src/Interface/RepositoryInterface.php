<?php

namespace Review\Interface;

interface RepositoryInterface
{

    public function getById(int $id);
    private function createModel($data);
}