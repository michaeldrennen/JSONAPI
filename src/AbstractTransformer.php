<?php

namespace MichaelDrennen\JSONAPI;

use Illuminate\Support\Collection;

abstract class AbstractTransformer {


    public abstract function transform( $item = NULL ): array;

    /**
     * @param Collection|mixed $sourceData
     * @return array
     */
    public function transformData( $sourceData = NULL ): array {

        if ( is_a( $sourceData, Collection::class ) || is_array( $sourceData ) ):
            $return = [];
            foreach ( $sourceData as $item ):
                $return[] = $this->transform( $item );
            endforeach;
            return $return;
        endif;

        return $this->transform( $sourceData );
    }

}
