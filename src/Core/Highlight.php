<?php

namespace Hypefactors\ElasticBuilder\Core;

use RuntimeException;
use Hypefactors\ElasticBuilder\Query\Query;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-body.html#request-body-search-highlighting
 */
class Highlight
{
    /**
     * The Highlight response.
     *
     * @var array
     */
    protected $body = [];

    /**
     * The fields to be highlighted.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * A string that contains each boundary character.
     *
     * @param string      $chars
     * @param string|null $field
     *
     * @return $this
     */
    public function boundaryChars(string $chars, ?string $field = null): self
    {
        $this->setFieldOption('boundary_chars', $chars, $field);

        return $this;
    }

    /**
     * How far to scan for boundary characters.
     *
     * @param int         $maxScan
     * @param string|null $field
     *
     * @return $this
     */
    public function boundaryMaxScan(int $maxScan, ?string $field = null): self
    {
        $this->setFieldOption('boundary_max_scan', $maxScan, $field);

        return $this;
    }

    /**
     * Indicates if the snippet should be HTML encoded:.
     *
     * @param string $encoder
     *
     * @return $this
     */
    public function encoder(string $encoder): self
    {
        $encoderLower = strtolower($encoder);

        $validEncoders = ['default', 'html'];

        if (! in_array($encoderLower, $validEncoders)) {
            throw new RuntimeException("The [{$encoder}] encoder is invalid!");
        }

        $this->body['encoder'] = $encoderLower;

        return $this;
    }

    /**
     * Adds a field to be highlighted.
     *
     * @param string $field
     *
     * @return $this
     */
    public function field(string $field): self
    {
        if (! isset($this->fields[$field])) {
            $this->fields[$field] = [];
        }

        return $this;
    }

    /**
     * Adds the given fields to be highlighted.
     *
     * @param array $fields
     *
     * @return $this
     */
    public function fields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->field($field);
        }

        return $this;
    }

    /**
     * Highlight based on the source even if the field is stored separately.
     *
     * @param bool        $forceSource
     * @param string|null $field
     *
     * @return $this
     */
    public function forceSource(bool $forceSource, ?string $field = null): self
    {
        $this->setFieldOption('force_source', $forceSource, $field);

        return $this;
    }

    /**
     * Specifies how text should be broken up in highlight snippets.
     *
     * @param string      $fragmenter
     * @param string|null $field
     *
     * @return $this
     */
    public function fragmenter(string $fragmenter, ?string $field = null): self
    {
        $fragmenterLower = strtolower($fragmenter);

        $validFragmenters = ['simple', 'span'];

        if (! in_array($fragmenterLower, $validFragmenters)) {
            throw new RuntimeException("The [{$fragmenter}] fragmenter is invalid!");
        }

        $this->setFieldOption('fragmenter', $fragmenterLower, $field);

        return $this;
    }

    /**
     * Controls the margin from which you want to start highlighting.
     *
     * @param int         $offset
     * @param string|null $field
     *
     * @return $this
     */
    public function fragmentOffset(int $offset, ?string $field = null): self
    {
        $this->type('fvh', $field);

        $this->setFieldOption('fragment_offset', $offset, $field);

        return $this;
    }

    /**
     * The size of the highlighted fragment in characters.
     *
     * @param int         $size
     * @param string|null $field
     *
     * @return $this
     */
    public function fragmentSize(int $size, ?string $field = null): self
    {
        $this->setFieldOption('fragment_size', $size, $field);

        return $this;
    }

    /**
     * Highlight matches for a query other than the search query.
     *
     * @param \Hypefactors\ElasticBuilder\Query\Query $query
     * @param string|null                             $field
     *
     * @return $this
     */
    public function highlightQuery(Query $query, ?string $field = null): self
    {
        $this->setFieldOption('highlight_query', $query, $field);

        return $this;
    }

    /**
     * Combine matches on multiple fields to highlight a single field.
     *
     * @param array  $fields
     * @param string $field
     *
     * @return $this
     */
    public function matchedFields(array $fields, string $field): self
    {
        $this->type('fvh', $field);

        $this->setFieldOption('matched_fields', $fields, $field);

        return $this;
    }

    /**
     * The amount of text you want to return from the beginning of the field if there are no matching fragments to highlight.
     *
     * @param int    $size
     * @param string $field
     *
     * @return $this
     */
    public function noMatchSize(int $size, string $field): self
    {
        $this->setFieldOption('no_match_size', $size, $field);

        return $this;
    }

    /**
     * The maximum number of fragments to return.
     *
     * @param int         $maxFragments
     * @param string|null $field
     *
     * @return $this
     */
    public function numberOfFragments(int $maxFragments, ?string $field = null): self
    {
        $this->setFieldOption('number_of_fragments', $maxFragments, $field);

        return $this;
    }

    /**
     * Sorts highlighted fragments by score when set to score.
     *
     * @param string $field
     *
     * @return $this
     */
    public function scoreOrder(?string $field = null): self
    {
        $this->setFieldOption('order', 'score', $field);

        return $this;
    }

    /**
     * Controls the number of matching phrases in a document that are considered.
     *
     * @param int $limit
     *
     * @return $this
     */
    public function phraseLimit(int $limit): self
    {
        $this->body['phrase_limit'] = $limit;

        return $this;
    }

    /**
     * Use in conjunction with post_tags to define the HTML tags to use for the highlighted text.
     *
     * @param array|string $tags
     * @param string       $field
     *
     * @return $this
     */
    public function preTags($tags, ?string $field = null): self
    {
        $tags = Util::arrayWrap($tags);

        $this->setFieldOption('pre_tags', $tags, $field);

        return $this;
    }

    /**
     * Use in conjunction with pre_tags to define the HTML tags to use for the highlighted text.
     *
     * @param array|string $tags
     * @param string       $field
     *
     * @return $this
     */
    public function postTags($tags, ?string $field = null): self
    {
        $tags = Util::arrayWrap($tags);

        $this->setFieldOption('post_tags', $tags, $field);

        return $this;
    }

    /**
     * By default, only fields that contains a query match are highlighted.
     *
     * @param bool        $requireFieldMatch
     * @param string|null $field
     *
     * @return $this
     */
    public function requireFieldMatch(bool $requireFieldMatch, ?string $field = null): self
    {
        $this->setFieldOption('require_field_match', $requireFieldMatch, $field);

        return $this;
    }

    /**
     * Set to styled to use the built-in tag schema.
     *
     * @return $this
     */
    public function tagsSchema(): self
    {
        $this->body['tags_schema'] = 'styled';

        return $this;
    }

    /**
     * The highlighter to use.
     *
     * @param string      $type
     * @param string|null $field
     *
     * @return $this
     */
    public function type(string $type, ?string $field = null): self
    {
        $typeLower = strtolower($type);

        $validTypes = ['unified', 'plain', 'fvh'];

        if (! in_array($typeLower, $validTypes)) {
            throw new RuntimeException("The [{$type}] type is invalid!");
        }

        $this->setFieldOption('type', $typeLower, $field);

        return $this;
    }

    /**
     * Returns the DSL Query as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $body = Util::recursivetoArray($this->body);

        $fields = Util::recursivetoArray($this->fields);

        return array_merge($body, [
            'fields' => $fields,
        ]);
    }

    /**
     * Sets the given option and value on either the body or if provided, on the field.
     *
     * @param mixed       $option
     * @param mixed       $value
     * @param string|null $field
     *
     * @return self
     */
    protected function setFieldOption($option, $value, ?string $field): self
    {
        if ($field) {
            $this->fields[$field][$option] = $value;
        } else {
            $this->body[$option] = $value;
        }

        return $this;
    }
}
