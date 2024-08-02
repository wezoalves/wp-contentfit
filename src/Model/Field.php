<?php

namespace Review\Model;

final class Field
{
    public string $id;
    public string $name;
    public string $type = "text";
    public string|null $group = "";
    public string|null $placeholder = "";
    public $value = null;
    public array $options = [];

    public function __construct(
        string $id,
        string $type,
        string $name,
        string $placeholder = "",
        $value = null,
        string $group = "",
        $options = [])
    {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->group = $group;
        $this->options = $options;
    }

    /**
     * Get the value of value
     *
     * @return any
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @param any $value
     *
     * @return self
     */
    public function setValue($value) : self
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
    public function getGroup() : string
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
    public function setGroup(string $group) : self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get the value of options
     *
     * @return array
     */
    public function getOptions() : array
    {
        return $this->options;
    }

    /**
     * Set the value of options
     *
     * @param array $options
     *
     * @return self
     */
    public function setOptions(array $options) : self
    {
        $this->options = $options;

        return $this;
    }
}