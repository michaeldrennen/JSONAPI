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


    /**
     * @test
     */
    public function errorShouldHaveAllTheOptions() {
        $user  = new User( 74, "Mike", TRUE );
        $array = \MichaelDrennen\JSONAPI\Response::create()
                                                 ->setData( $user )
                                                 ->transformWith( new UserTransformer() )
                                                 ->addError( \MichaelDrennen\JSONAPI\Error::create()
                                                                                          ->setCode( 667 )
                                                                                          ->addLink( 'https://google.com',
                                                                                                     'testLink1' )
                                                                                          ->addLink( 'https://yahoo.com' )
                                                                                          ->setAbout( "This is the about text for this error." )
                                                                                          ->setDetail( "This is the detail regarding this error." )
                                                                                          ->setId( 77 )
                                                                                          ->setSource( NULL )
                                                                                          ->setStatus( 124523 )
                                                                                          ->setTitle( "This is the title of the error." )
                                                 )
                                                 ->toArray();

        $this->assertEquals( 667, $array[ 'errors' ][ 0 ][ 'code' ] );
        $this->assertEquals( 77, $array[ 'errors' ][ 0 ][ 'id' ] );
    }

}