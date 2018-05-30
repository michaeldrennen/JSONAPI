<?php

use PHPUnit\Framework\TestCase;


class JSONAPITest extends TestCase {

    /**
     * @test
     */
    public function toArrayShouldReturnArray() {

        $array = \MichaelDrennen\JSONAPI\Response::create()
                                                 ->transformWith( new UserTransformer() )
                                                 ->toArray();
        $this->assertTrue( is_array( $array ) );
    }

    /**
     * @test
     */
    public function missingTransformerShouldThrowException() {
        $this->expectException( Exception::class );
        $user  = new User( 74, "Mike", TRUE );
        $array = \MichaelDrennen\JSONAPI\Response::create()
                                                 ->setData( $user )
                                                 ->toArray();
    }


    /**
     * @test
     */
    public function transformerShouldRemoveName() {
        $user  = new User( 74, "Mike", TRUE );
        $array = \MichaelDrennen\JSONAPI\Response::create()
                                                 ->setData( $user )
                                                 ->transformWith( new UserTransformer() )
                                                 ->toArray();

        $this->assertFalse( isset( $array[ 'data' ][ 'name' ] ) );
    }


}