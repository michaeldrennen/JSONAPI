<?php

namespace MichaelDrennen\JSONAPI;

use Illuminate\Support\Collection;

abstract class AbstractTransformer {

    protected $keyFieldName = NULL;

    /**
     * AbstractTransformer constructor.
     * @param string|NULL $keyFieldName Want to pass in an array (or Collection or other Iterable type) and you want
     *                                  the output to be keyed instead of numerically indexed? Provide the field name
     *                                  of the item to be transformed that you want to be the key in the returned data
     *                                  set.
     */
    public function __construct( string $keyFieldName = NULL ) {
        $this->keyFieldName = $keyFieldName;
    }

    /**
     * @param null $item
     * @return array
     */
    public abstract function transform( $item = NULL ): array;

    /**
     * Getter
     * @return null|string
     */
    public function getKey() {
        return $this->keyFieldName;
    }
}
