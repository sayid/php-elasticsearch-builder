<?php

namespace Hypefactors\ElasticBuilder\Query\Joining;

use RuntimeException;
use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-exists-query.html
 */
class HasQuery extends Query
{
    /**
     * Sets the field to search on.
     *
     * @param string $field
     *
     * @return $this
     */
    public function field(string $field): self
    {
        $this->body['field'] = $field;

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
        if (! isset($this->body['field'])) {
            throw new RuntimeException('The "field" is required!');
        }

        return [
            'exists' => Util::recursivetoArray($this->body),
        ];
    }
}
