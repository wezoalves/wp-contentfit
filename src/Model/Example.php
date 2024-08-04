<?php

namespace Review\Model;

final class Example
{
    public string|null $id;
    public string|null $name;
    public string|null $type = "text";
    public $value = null;
    public array|null $options = [];

    public function __construct(
        string|null $id,
        string|null $type,
        string|null $name,
        $value = null,
        $options = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;
    }


    /**
     * Get the value of id
     *
     * @return string
     */
    public function getId(): string
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
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
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
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of type
     *
     * @return string
     */
    public function getType(): string
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
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of options
     *
     * @return array
     */
    public function getOptions(): array
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
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }
}