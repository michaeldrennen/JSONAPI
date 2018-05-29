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
    protected $errors;

    /**
     * @var array A meta object that contains non-standard meta-information.
     */
    protected $meta;


    protected $sourceData  = NULL;
    protected $transformer = NULL;

    public function __construct() {

    }

    public static function create() {
        return new Response();
    }

    public function setData( $data ): Response {
        $this->sourceData = $data;
        return $this;
    }


    public function transformWith( $transformer ): Response {
        $this->transformer = $transformer;
        return $this;
    }

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
     * @throws \Exception
     */
    public function toArray(): array {
        $this->transformData();
        return [
            'data'   => $this->data,
            'errors' => [],
            'meta'   => [],
        ];
    }

    /**
     * @throws \Exception
     */
    protected function transformData() {
        if ( is_null( $this->transformer ) ):
            throw new \Exception( "You need to set a transformer." );
        endif;
        $this->data = $this->transformer->transform( $this->sourceData );
    }
}
