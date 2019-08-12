<?php

namespace Hypefactors\ElasticBuilder\Query\Compound;

use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-boosting-query.html
 */
class BoostingQuery extends Query
{
    public function positive(Query $query): self
    {
        $this->body['positive'] = $query;

        return $this;
    }

    public function negative(Query $query): self
    {
        $this->body['negative'] = $query;

        return $this;
    }

    public function negativeBoost($factor): self
    {
        $this->body['negative_boost'] = $factor;

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'boosting' => Util::recursivetoArray($this->body),
        ];
    }
}
