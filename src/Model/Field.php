<?php

namespace Review\Model;

final class Field
{
    public string $id;
    public string $name;
    public string $type;
    public string|null $group = "";
    public string|null $value = null;
    public string|null $placeholder = "";

    public function __construct(
        string $id,
        string $type,
        string $name,
        string $placeholder = "",
        string $value = null,
        string $group = "")
    {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->group = $group;
    }

    /**
     * Get the value of value
     *
     * @return string
     */
    public function getValue() : string
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @param string $value
     *
     * @return self
     */
    public function setValue(string $value) : self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of type
     *
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param string $type
     *
     * @return self
     */
    public function setType(string $type) : self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param string $id
     *
     * @return self
     */
    public function setId(string $id) : self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of placeholder
     *
     * @return string
     */
    public function getPlaceholder() : string
    {
        return $this->placeholder;
    }

    /**
     * Set the value of placeholder
     *
     * @param string $placeholder
     *
     * @return self
     */
    public function setPlaceholder(string $placeholder) : self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get the value of group
     *
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * Set the value of group
     *
     * @param string $group
     *
     * @return self
     */
    public function setGroup(string $group): self
    {
        $this->group = $group;

        return $this;
    }
}