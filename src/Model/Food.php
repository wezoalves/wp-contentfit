<?php

namespace Review\Model;

final class Food
{
    public int $id;
    public string $name;
    public string $description = "";
    public string $url = "";
    public array $composition;


    public function __construct(string $name, string $description = "", string $url = "", array $composition = [])
    {
        $this->name = $name;
        $this->description = $description;
        $this->url = $url;
        $this->composition = $composition;
    }


    public function getName() : string
    {
        return $this->name;
    }


    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }


    public function getDescription() : string
    {
        return $this->description;
    }


    public function setDescription(string $description) : self
    {
        $this->description = $description;

        return $this;
    }


    public function getUrl() : string
    {
        return $this->url;
    }


    public function setUrl(string $url) : self
    {
        $this->url = $url;

        return $this;
    }


    public function getComposition() : array
    {
        return $this->composition;
    }


    public function setComposition(array $composition) : self
    {
        $this->composition = $composition;

        return $this;
    }

    public function addComposition(Field $composition) : self
    {
        $this->composition[] = $composition;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
