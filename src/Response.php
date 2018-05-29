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
        $arrayErrors = [];
        foreach ( $this->errors as $index => $error ):
            $arrayErrors[ $index ] = $error->toArray();
        endforeach;
        return [
            'data'   => $this->data,
            'errors' => $arrayErrors,
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
