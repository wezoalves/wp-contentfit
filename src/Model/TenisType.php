<?php

namespace Review\Model;

final class TenisType
{
    private string|null $id;
    private string|null $name;
    public function __construct(
        string $id,
        string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() : ?string
    {
        return $this->id;
    }
    public function setId(?string $id) : self
    {
        $this->id = $id;
        return $this;
    }

    public function getName() : ?string
    {
        return $this->name;
    }
    public function setName(?string $name) : self
    {
        $this->name = $name;
        return $this;
    }
}
