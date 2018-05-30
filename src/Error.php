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
     * @var array An array of URI's (hrefs) or Link Objects as defined by the link below.
     * @link http://jsonapi.org/format/#document-links
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
     * @var string A short, human-readable summary of the problem that SHOULD NOT change from occurrence to occurrence
     *      of the problem, except for purposes of localization.
     */
    protected $title;

    /**
     * @var string A human-readable explanation specific to this occurrence of the problem. Like title, this field’s
     *      value can be localized.
     */
    protected $detail;

    /**
     * TODO I don't plan on implementing this just yet.
     * @var array An object containing references to the source of the error, optionally including any of the following
     *      members: pointer: a JSON Pointer [RFC6901] to the associated entity in the request document [e.g. "/data"
     *      for a primary data object, or "/data/attributes/title" for a specific attribute]. parameter: a string
     *      indicating which URI query parameter caused the error. meta: a meta object containing non-standard
     *      meta-information about the error.
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

    public function setId( string $id = NULL ): Error {
        $this->id = $id;
        return $this;
    }

    /**
     * @param      $link  string An array of URI's (href) or Link Objects as defined by the link below.
     * @param null $index string
     * @return \MichaelDrennen\JSONAPI\Error
     * @link http://jsonapi.org/format/#document-links
     */
    public function addLink( $link, $index = NULL ): Error {
        if ( $index ):
            $this->links[ $index ] = $link;
        else:
            $this->links[] = $link;
        endif;

        return $this;
    }

    /**
     * @param string $about Link that leads to further details about this particular occurrence of the problem.
     * @return \MichaelDrennen\JSONAPI\Error
     */
    public function setAbout( string $about ): Error {
        $this->about = $about;
        return $this;
    }

    /**
     * @param string $status HTTP status code applicable to this problem, expressed as a string value.
     * @return \MichaelDrennen\JSONAPI\Error
     */
    public function setStatus( string $status ): Error {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string $code Application-specific error code, expressed as a string value.
     * @return \MichaelDrennen\JSONAPI\Error
     */
    public function setCode( string $code ): Error {
        $this->code = $code;
        return $this;
    }


    /**
     * @param string $title A short, human-readable summary of the problem that SHOULD NOT change from occurrence to
     *                      occurrence of the problem, except for purposes of localization.
     * @return \MichaelDrennen\JSONAPI\Error
     */
    public function setTitle( string $title ): Error {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $detail A human-readable explanation specific to this occurrence of the problem. Like title, this
     *                       field’s value can be localized.
     * @return \MichaelDrennen\JSONAPI\Error
     */
    public function setDetail( string $detail ): Error {
        $this->detail = $detail;
        return $this;
    }

    /**
     * TODO Not sure I want to implement this yet.
     * @param $source array An object containing references to the source of the error, optionally including any of the
     *                following members: pointer: a JSON Pointer [RFC6901] to the associated entity in the request
     *                document [e.g. "/data" for a primary data object, or "/data/attributes/title" for a specific
     *                attribute]. parameter: a string indicating which URI query parameter caused the error. meta: a
     *                meta object containing non-standard meta-information about the error.
     * @return \MichaelDrennen\JSONAPI\Error
     */
    public function setSource( $source ): Error {
        $this->source = $source;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array {
        return [
            'id'     => $this->id,
            'links'  => $this->links,
            'about'  => $this->about,
            'status' => $this->status,
            'code'   => $this->code,
            'title'  => $this->title,
            'detail' => $this->detail,
            'source' => $this->source,
        ];
    }


}
