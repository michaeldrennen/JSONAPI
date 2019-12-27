<?php

namespace MichaelDrennen\JSONAPI;

use MichaelDrennen\JSONAPI\Error;

/**
 * Class Response
 * @package MichaelDrennen\JSONAPI
 * $response = Response::create()
 * ->data($user)
 * ->transformWith(new UserTransformer())
 * ->addError(Error::create()
 * ->setCode(UsersController::ERROR_CODE_EMAIL_ALREADY_CONFIRMED)
 * ->setMessage(trans()))
 * ->addMeta()
 * ->toArray();
 */
class Response {


    /**
     * @var array The document's "primary data"
     * @link http://jsonapi.org/format/#document-top-level
     */
    protected $data;

    /**
     * @var array an array of error objects
     */
    protected $errors = [];

    /**
     * @var array A meta object that contains non-standard meta-information.
     */
    protected $meta;


    /**
     * @var mixed An object, array, or Collection
     */
    protected $sourceData = NULL;

    /**
     * @var \MichaelDrennen\JSONAPI\AbstractTransformer The developer supplied transformer that determines what data
     *      gets returned in the Response.
     */
    protected $transformer = NULL;


    /**
     * The field name from the Model
     * @var string|array|null
     */
    protected $groupBy = NULL;

    /**
     * TODO I could probably make this protected, since it should only be called by the static create() method.
     * Response constructor.
     */
    public function __construct() {

    }

    /**
     * @return \MichaelDrennen\JSONAPI\Response
     */
    public static function create() {
        return new Response();
    }

    /**
     * @param null $data
     * @return \MichaelDrennen\JSONAPI\Response
     */
    public function setData( $data = NULL ): Response {
        $this->sourceData = $data;
        return $this;
    }


    /**
     * @param $field
     * @return Response
     */
    public function groupBy( $field ): Response {
        $this->groupBy = $field;
        return $this;
    }

    /**
     * @param null $meta
     * @return \MichaelDrennen\JSONAPI\Response
     */
    public function setMeta( $meta = NULL ): Response {
        $this->meta = $meta;
        return $this;
    }


    /**
     * @param null $transformer
     * @return \MichaelDrennen\JSONAPI\Response
     */
    public function transformWith( $transformer = NULL ): Response {
        $this->transformer = $transformer;
        return $this;
    }

    /**
     * @param \MichaelDrennen\JSONAPI\Error $error
     * @param null $index
     * @return \MichaelDrennen\JSONAPI\Response
     */
    public function addError( Error $error, $index = NULL ): Response {
        if ( $index ):
            $this->errors[ $index ] = $error;
        else:
            $this->errors[] = $error;
        endif;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array {
        $this->transformData();

        if ( $this->groupBy && is_array($this->groupBy) ):
            $this->data = $this->groupDataByArrayOfKeys($this->groupBy, $this->data );
        elseif($this->groupBy):
            $this->data = $this->groupDataByKey( $this->groupBy, $this->data );
        endif;


        $arrayErrors = [];
        foreach ( $this->errors as $index => $error ):
            $arrayErrors[ $index ] = $error->toArray();
        endforeach;
        return [
            'data'   => $this->data,
            'errors' => $arrayErrors,
            'meta'   => $this->meta,
        ];
    }

    /**
     * If there is a transformer assigned to this Response, then allow it to transform the source data according to its
     * rules. Otherwise, just plop the source data into the Response's data property.
     */
    protected function transformData() {
        $this->data = [];
        if ( is_null( $this->transformer ) ):
            $this->data = (array)$this->sourceData;
        else:
            if ( is_iterable( $this->sourceData ) ):

                foreach ( $this->sourceData as $key => $data ):
                    if ( !is_null( $this->transformer->getKey() ) && isset( $data->{$this->transformer->getKey()} ) ):
                        $this->data[ $data->{$this->transformer->getKey()} ] = $this->transformer->transform( $data );
                    else:
                        $this->data[ $key ] = $this->transformer->transform( $data );
                    endif;
                endforeach;
            else:
                $this->data = $this->transformer->transform( $this->sourceData );
            endif;
        endif;
    }


    /**
     * This should really be a helper function or part of PHP's core.
     * @param $key
     * @param array $data
     * @return array
     */
    protected function groupDataByKey( $key, array $data ): array {

        $result = [];
        foreach ( $data as $i => $object ):
            if ( FALSE === isset( $result[ $object[ $key ] ] ) ):
                $result[ $object[ $key ] ] = [];
            endif;

            $result[ $object[ $key ] ][] = $object;
        endforeach;

        return $result;
    }

    protected function groupDataByArrayOfKeys( array $keys, array $data ): array {

        return collect($data)->groupBy($keys)->toArray();



//        $result = [];
//
//        $reversedKeys = array_reverse( $keys );
//
//        $resultsByKey = [];
//        foreach($reversedKeys as $key):
//            $resultsByKey = $this->groupDataByKey($key, $data);
//        endforeach;
//
//
//        foreach ( $data as $i => $object ):
//            $fieldValuePairsForObject = [];
//            foreach ( $keys as $field ):
//                $fieldValuePairsForObject
//            endforeach;
//
//            if ( FALSE === isset( $result[ $object[ $key ] ] ) ):
//                $result[ $object[ $key ] ] = [];
//            endif;
//
//            $result[ $object[ $key ] ][] = $object;
//        endforeach;
//
//
//        foreach ( $data as $i => $object ):
//            if ( FALSE === isset( $result[ $object[ $key ] ] ) ):
//                $result[ $object[ $key ] ] = [];
//            endif;
//
//            $result[ $object[ $key ] ][] = $object;
//        endforeach;
//
//        return $result;
    }
}
