<?php

namespace Hypefactors\ElasticBuilder\Aggregation;

use RuntimeException;

abstract class Aggregation
{
    /**
     * The Aggregation name.
     *
     * @var string
     */
    protected $name;

    /**
     * The Aggregation body.
     *
     * @var array
     */
    protected $body = [];

    /**
     * The Aggregation Metadata.
     *
     * @var array
     */
    protected $meta = [];

    /**
     * The Nested Aggregations of this Aggregation.
     *
     * @var array
     */
    protected $nestedAggregations = [];

    /**
     * Sets the Aggregation name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function aggregation(Aggregation $aggregation): self
    {
        $this->nestedAggregations[] = $aggregation;

        return $this;
    }

    public function aggregations(array $aggregations): self
    {
        foreach ($aggregations as $aggregation) {
            $this->aggregation($aggregation);
        }

        return $this;
    }

    /**
     * Sets the Aggregation Metadata.
     *
     * @param array $meta
     *
     * @return $this
     */
    public function meta(array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Returns the Aggregation body.
     *
     * @return array
     */
    abstract public function getBody(): array;

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        if (! $this->name) {
            throw new RuntimeException('The Aggregation "name" is required!');
        }

        $body = $this->getBody();

        if (! empty($this->nestedAggregations)) {
            $nestedAggregations = [];

            foreach ($this->nestedAggregations as $nestedAggregation) {
                $nestedAggregations += $nestedAggregation->toArray();
            }

            $body['aggs'] = $nestedAggregations;
        }

        if (! empty($this->meta)) {
            $body['meta'] = $this->meta;
        }

        return [
            $this->name => $body,
        ];
    }
}
