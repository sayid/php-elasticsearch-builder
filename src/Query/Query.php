<?php

namespace Hypefactors\ElasticBuilder\Query;

abstract class Query
{
    /**
     * The DSL Query body.
     *
     * @var array
     */
    protected $body = [];

    /**
     * Sets the boost value to increase or decrease the relevance scores of this query.
     *
     * @param float $factor
     *
     * @return $this
     */
    public function boost(float $factor): self
    {
        $this->body['boost'] = $factor;

        return $this;
    }

    /**
     * Sets the query name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function name(string $name): self
    {
        $this->body['_name'] = $name;

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    abstract public function toArray(): array;

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
