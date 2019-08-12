<?php

namespace Hypefactors\ElasticBuilder\Core;

use stdClass;
use RuntimeException;

/**
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-body.html#request-body-search-sort
 */
class Sort
{
    /**
     * The field to be sorted.
     *
     * @var string
     */
    protected $field;

    /**
     * The sorting options to be applied.
     *
     * @var array
     */
    protected $options;

    protected $geoPoint = [];

    protected $script = [];

    /**
     * The field to be sorted.
     *
     * @param string $field
     *
     * @return $this
     */
    public function field(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function geoDistance(GeoPoint $geoPoint): self
    {
        $this->geoPoint = $geoPoint;

        return $this;
    }

    /**
     * Sets the order for sorting.
     *
     * @param string $order
     *
     * @return $this
     */
    public function order(string $order): self
    {
        $orderLower = strtolower($order);

        $validOrders = ['asc', 'desc'];

        if (! in_array($orderLower, $validOrders)) {
            throw new RuntimeException("The [{$order}] order is invalid!");
        }

        $this->options['order'] = $orderLower;

        return $this;
    }

    /**
     * Sets the mode option that controls what array value
     * is picked for sorting the document it belongs to.
     *
     * @param string $mode
     *
     * @return $this
     */
    public function mode(string $mode): self
    {
        $modeLower = strtolower($mode);

        $validModes = ['min', 'max', 'sum', 'avg', 'median'];

        if (! in_array($modeLower, $validModes)) {
            throw new RuntimeException("The [{$mode}] mode is invalid!");
        }

        $this->options['mode'] = $modeLower;

        return $this;
    }

    /**
     * For numeric fields it is also possible to cast the values
     * from one type to another using the numeric_type option.
     *
     * @param string $numericType
     *
     * @return self
     */
    public function numericType(string $numericType): self
    {
        $numericTypeLower = strtolower($numericType);

        $validNumericTypes = ['double', 'long', 'date', 'date_nanos'];

        if (! in_array($numericTypeLower, $validNumericTypes)) {
            throw new RuntimeException("The [{$numericType}] numeric type is invalid!");
        }

        $this->options['numeric_type'] = $numericTypeLower;

        return $this;
    }

    /**
     * The missing parameter specifies how docs which are missing the sort field should be treated.
     *
     * @param int|string $value
     *
     * @return $this
     */
    public function missing($value): self
    {
        $this->options['missing'] = $value;

        return $this;
    }

    /**
     * The `unmapped_type` option allows to ignore fields that have no mapping
     * and not sort by them.
     *
     * @param string $type
     *
     * @return $this
     */
    public function unmappedType(string $type): self
    {
        $this->options['unmapped_type'] = $type;

        return $this;
    }

    /**
     * Returns the DSL Sort as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        if (empty($this->geoPoint) && empty($this->script)) {
            if (empty($this->options)) {
                return [
                    $this->field => new stdClass(),
                ];
            }

            if (count($this->options) === 1 && isset($this->options['order'])) {
                return [
                    $this->field => $this->options['order'],
                ];
            }

            $response = [
                $this->field => $this->options,
            ];
        }

        if (! empty($this->geoPoint)) {
            $response = [
                '_geo_distance' => [
                    $this->field => array_merge($this->geoPoint, $this->options),
                ],
            ];
        }

        if (! empty($this->script)) {
            $response = [
                '_script' => [
                    $this->field => array_merge($this->script, $this->options),
                ],
            ];
        }

        return Util::recursivetoArray($response);
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
