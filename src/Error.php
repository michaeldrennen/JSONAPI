<?php

namespace MichaelDrennen\JSONAPI;


/**
 * Class Error
 * @package MichaelDrennen\JSONAPI
 * @link    http://jsonapi.org/format/#error-objects
 */
class Error {

    /**
     * id:
     * links:
     * about:
     * status:
     * code:
     * title:
     * detail:
     * source:
     **/

    /**
     * @var string Unique identifier for this particular occurrence of the problem.
     */
    protected $id;

    /**
     * @var array A links object containing the following members:
     */
    protected $links;

    /**
     * @var string Link that leads to further details about this particular occurrence of the problem.
     */
    protected $about;

    /**
     * @var string HTTP status code applicable to this problem, expressed as a string value.
     */
    protected $status;

    /**
     * @var string Application-specific error code, expressed as a string value.
     */
    protected $code;

    /**
     * @var string A short, human-readable summary of the problem that SHOULD NOT change from occurrence to occurrence of the problem, except for purposes of localization.
     */
    protected $title;

    /**
     * @var string A human-readable explanation specific to this occurrence of the problem. Like title, this field’s value can be localized.
     */
    protected $detail;

    /**
     * TODO I don't plan on implementing this just yet.
     * @var array An object containing references to the source of the error, optionally including any of the following members: pointer: a JSON Pointer [RFC6901] to the associated entity in the request document [e.g. "/data" for a primary data object, or "/data/attributes/title" for a specific attribute]. parameter: a string indicating which URI query parameter caused the error. meta: a meta object containing non-standard meta-information about the error.
     */
    protected $source;

    /**
     * @var array
     */
    protected $meta;


    public function __construct() {

    }

    public static function create() {
        return new Error();
    }


}
