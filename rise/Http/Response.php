<?php

namespace Rise\Http;

use \Phalcon\Http\Response as BaseResponse,

    \Rise\Models\Response\Base as Body;

/**
 * Class Base
 * @package Rise\Http
 */
class Response extends BaseResponse {

    /**
     * @param Body $body
     * @param int|null $code
     * @param string|null $status
     */
    public function __construct(Body $body, $code = null, $status = null) {
        parent::__construct(null, $code, $status);
        $this->setContentType('application/json');
        $this->setHeader('Access-Control-Allow-Origin', '*');
        $this->setHeader('Access-Control-Allow-Methods', 'GET,HEAD,PUT,PATCH,POST,DELETE');
        $this->setHeader('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization');
        $this->setJsonContent($body);
    }

}