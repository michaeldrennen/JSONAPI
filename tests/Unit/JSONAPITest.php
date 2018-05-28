<?php

use PHPUnit\Framework\TestCase;


class JSONAPITest extends TestCase {

    /**
     * @test
     */
    public function toArrayShouldReturnArray() {

        $array = \MichaelDrennen\JSONAPI\Response::create()
                                                 ->toArray();
        $this->assertTrue( is_array( $array ) );
    }


}