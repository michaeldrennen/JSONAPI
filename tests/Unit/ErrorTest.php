<?php

use PHPUnit\Framework\TestCase;


class ErrorTest extends TestCase {
    /**
     * @test
     */
    public function addIndexedErrorShouldHaveErrorCode() {
        $user  = new User( 74, "Mike", TRUE );
        $array = \MichaelDrennen\JSONAPI\Response::create()
                                                 ->setData( $user )
                                                 ->transformWith( new UserTransformer() )
                                                 ->addError( \MichaelDrennen\JSONAPI\Error::create()
                                                                                          ->setCode( 666 )
                                                     , 'test' )
                                                 ->toArray();
        $this->assertEquals( 666, $array[ 'errors' ][ 'test' ][ 'code' ] );
    }

    /**
     * @test
     */
    public function addErrorShouldHaveErrorCode() {
        $user  = new User( 74, "Mike", TRUE );
        $array = \MichaelDrennen\JSONAPI\Response::create()
                                                 ->setData( $user )
                                                 ->transformWith( new UserTransformer() )
                                                 ->addError( \MichaelDrennen\JSONAPI\Error::create()
                                                                                          ->setCode( 667 )
                                                 )
                                                 ->toArray();

        $this->assertEquals( 667, $array[ 'errors' ][ 0 ][ 'code' ] );
    }

}