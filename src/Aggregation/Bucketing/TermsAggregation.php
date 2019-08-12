<?php

namespace Hypefactors\ElasticBuilder\Aggregation\Bucketing;

use RuntimeException;
use Hypefactors\ElasticBuilder\Core\Util;
use Hypefactors\ElasticBuilder\Core\Script;
use Hypefactors\ElasticBuilder\Aggregation\Aggregation;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-terms-aggregation.html
 */
class TermsAggregation extends Aggregation
{
    public function field(string $field): self
    {
        $this->body['field'] = $field;

        return $this;
    }

    public function collectMode(string $mode): self
    {
        $modeLower = strtolower($mode);

        $validModes = ['breadth_first', 'depth_first'];

        if (! in_array($modeLower, $validModes)) {
            throw new RuntimeException("The [{$mode}] mode is not valid!");
        }

        $this->body['collect_mode'] = $modeLower;

        return $this;
    }

    public function order(string $key, string $direction): self
    {
        if (! isset($this->body['order'])) {
            $this->body['order'] = [];
        }

        $this->body['order'][] = [$key => $direction];

        return $this;
    }

    public function script(Script $script): self
    {
        $this->body['script'] = $script;

        return $this;
    }

    public function size(int $size): self
    {
        $this->body['size'] = $size;

        return $this;
    }

    public function shardSize(int $size): self
    {
        $this->body['shard_size'] = $size;

        return $this;
    }

    public function showTermDocCountError(bool $status): self
    {
        $this->body['show_term_doc_count_error'] = $status;

        return $this;
    }

    public function minDocCount(int $minDocCount): self
    {
        $this->body['min_doc_count'] = $minDocCount;

        return $this;
    }

    public function shardMinDocCount(int $minDocCount): self
    {
        $this->body['shard_min_doc_count'] = $minDocCount;

        return $this;
    }

    public function include($clause): self
    {
        $this->body['include'] = $clause;

        return $this;
    }

    public function exclude($clause): self
    {
        $this->body['exclude'] = $clause;

        return $this;
    }

    public function missing(string $value): self
    {
        $this->body['missing'] = $value;

        return $this;
    }

    public function executionHint(string $hint): self
    {
        $hintLower = strtolower($hint);

        $validHints = ['map', 'global_ordinals', 'global_ordinals_hash', 'global_ordinals_low_cardinality'];

        if (! in_array($hintLower, $validHints)) {
            throw new RuntimeException("The [{$hint}] hint is not valid!");
        }

        $this->body['execution_hint'] = $hintLower;

        return $this;
    }

    public function getBody(): array
    {
        if (! isset($this->body['field'])) {
            throw new RuntimeException('The "field" is required!');
        }

        return [
            'terms' => Util::recursivetoArray($this->body),
        ];
    }
}
