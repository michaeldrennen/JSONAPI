<?php

class UserTransformer extends \MichaelDrennen\JSONAPI\AbstractTransformer {

    public function transform( $item = NULL ): array {

        if ( is_null( $item ) ):
            return [];
        endif;
        return [
            'id'   => $item->id,
            'admin' => $item->admin,
        ];

    }
}