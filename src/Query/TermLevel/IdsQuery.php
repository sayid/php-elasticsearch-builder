<?php

namespace Hypefactors\ElasticBuilder\Query\TermLevel;

use RuntimeException;
use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-ids-query.html
 */
class IdsQuery extends Query
{
    /**
     * Sets the type of the documents to be returned.
     *
     * @param string $ids
     *
     * @return $this
     */
    public function type(string $type): self
    {
        $this->body['type'] = $type;

        return $this;
    }

    /**
     * Sets the documents ids to be returned.
     *
     * @param string $ids
     *
     * @return $this
     */
    public function values(array $ids): self
    {
        $this->body['values'] = $ids;

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
        if (! isset($this->body['values'])) {
            throw new RuntimeException('The "values" are required!');
        }

        if (empty($this->body['values'])) {
            throw new RuntimeException('The "values" cannot be empty!');
        }

        return [
            'ids' => Util::recursivetoArray($this->body),
        ];
    }
}
