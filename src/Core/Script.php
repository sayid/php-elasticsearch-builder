<?php

namespace Hypefactors\ElasticBuilder\Core;

use RuntimeException;

class Script
{
    /**
     * The DSL Query body.
     *
     * @var array
     */
    protected $body = [];

    /**
     * Specifies the id of the stored script.
     *
     * @param string $id
     *
     * @return $this
     */
    public function id(string $id): self
    {
        $this->body['id'] = $id;

        return $this;
    }

    /**
     * Specifies the source of the script.
     *
     * @param string $source
     *
     * @return $this
     */
    public function source(string $source): self
    {
        $this->body['source'] = $source;

        return $this;
    }

    /**
     * Specifies the language the script is written in.
     *
     * @param string $language
     *
     * @return $this
     */
    public function language(string $language): self
    {
        $this->body['lang'] = $language;

        return $this;
    }

    /**
     * Specifies any named parameters that are passed into the script as variables.
     *
     * @param array $parameters
     *
     * @return $this
     */
    public function parameters(array $parameters): self
    {
        $this->body['params'] = $parameters;

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    public function toArray(): array
    {
        if (! isset($this->body['source']) && ! isset($this->body['id'])) {
            throw new RuntimeException('The "source" or "id" is required!');
        }

        if (isset($this->body['source'], $this->body['id'])) {
            throw new RuntimeException('Passing both "source" and "id" at the same time is not allowed.');
        }

        return Util::arrayWrap($this->body);
    }

    /**
     * Returns the query in JSON format.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
