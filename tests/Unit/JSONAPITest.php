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
     * @group meta
     */
    public function toArrayWithSetMetaShouldReturnArrayWithMeta() {

        $array = \MichaelDrennen\JSONAPI\Response::create()
                                                 ->transformWith( new UserTransformer() )
                                                 ->setMeta( [ 'foo' => 'bar' ] )
                                                 ->toArray();
        $this->assertTrue( is_array( $array[ 'meta' ] ) );
        $this->assertEquals( 'bar', $array[ 'meta' ][ 'foo' ] );
    }

    /**
     * @test
     */
    public function missingTransformerShouldReturnUnchangedItem() {
        $user  = new User( 74, "Mike", TRUE );
        $array = \MichaelDrennen\JSONAPI\Response::create()
                                                 ->setData( $user )
                                                 ->toArray();
        $this->assertCount( 5, $array[ 'data' ] );
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

    /**
     * @test
     */
    public function toArrayShouldTransformArrayOfObjects() {
        $users = [
            new User( 74, "Mike", TRUE ),
            new User( 90, "Joe", FALSE ),
            new User( 125, "Tom", FALSE ),
        ];
        $array = \MichaelDrennen\JSONAPI\Response::create()
                                                 ->setData( $users )
                                                 ->transformWith( new UserTransformer() )
                                                 ->toArray();

        $this->assertTrue( $array[ 'data' ][ 0 ][ 'id' ] == 74 );
        $this->assertFalse( isset( $array[ 'data' ][ 0 ][ 'name' ] ) );
        $this->assertCount( 3, $array[ 'data' ] );

    }


    /**
     * @test
     */
    public function toArrayWithKeyShouldTransformArrayOfObjectsToAssociativeArray() {
        $users = [
            new User( 74, "Mike", TRUE ),
            new User( 90, "Joe", FALSE ),
            new User( 125, "Tom", FALSE ),
        ];
        $array = \MichaelDrennen\JSONAPI\Response::create()
                                                 ->setData( $users )
                                                 ->transformWith( new UserTransformer( 'id' ) )
                                                 ->toArray();

        $this->assertTrue( $array[ 'data' ][ 74 ][ 'admin' ] == TRUE );

    }


    /**
     * @test
     * @group group
     */
    public function toArrayWithGroupByShouldReturnNestedArray() {
        $users = [
            new User( 74, "Mike", TRUE, 'accounting' ),
            new User( 90, "Joe", FALSE, 'accounting' ),
            new User( 125, "Tom", FALSE, 'janitorial' ),
            new User( 135, "Barry", FALSE, 'janitorial' ),
        ];
        $array = \MichaelDrennen\JSONAPI\Response::create()
                                                 ->setData( $users )
                                                 ->groupBy( 'department' )
                                                 ->transformWith( new UserTransformer() )
                                                 ->toArray();

        $this->assertTrue( is_array( $array[ 'data' ] ) );
        $this->assertTrue( is_array( $array[ 'data' ][ 'accounting' ] ) );
        $this->assertCount( 2, $array[ 'data' ][ 'accounting' ] );
    }


    /**
     * @test
     * @group multiple
     */
    public function toArrayWithMultipleGroupByFieldsShouldReturnDoubleNestedArray() {
        $users = [
            new User( 74, "Mike", TRUE, 'accounting', 'Steamboat Springs' ),
            new User( 90, "Joe", FALSE, 'accounting', 'Craig' ),
            new User( 125, "Tom", TRUE, 'janitorial', 'Steamboat Springs' ),
            new User( 135, "Barry", FALSE, 'janitorial', 'Craig' ),
        ];

        $array = \MichaelDrennen\JSONAPI\Response::create()
                                                 ->setData( $users )
                                                 ->groupBy( [ 'city', 'department' ] )
                                                 ->transformWith( new UserTransformer() )
                                                 ->toArray();

        $this->assertTrue( is_array( $array[ 'data' ] ) );
        $this->assertTrue( is_array( $array[ 'data' ][ 'Steamboat Springs' ] ) );
        $this->assertTrue( is_array( $array[ 'data' ][ 'Steamboat Springs' ][ 'accounting' ] ) );
    }

}