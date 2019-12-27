<?php

class UserTransformer extends \MichaelDrennen\JSONAPI\AbstractTransformer {

    /**
     * Specifically removes the name property from the User object.
     * @param \User $item
     * @return array
     */
    public function transform( $item = NULL ): array {

        if ( is_null( $item ) ):
            return [];
        endif;
        return [
            'id'         => $item->id,
            'admin'      => $item->admin,
            'department' => $item->department,
            'city'       => $item->city,
        ];

    }
}