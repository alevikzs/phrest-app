<?php

namespace Rise\Controller;

use \Phalcon\Http\Response,
    \Phalcon\Http\Request,

    \Rise\RequestPayload,
    \Rise\Controller,
    \Rise\Exception\Validation as ValidationException;

/**
 * Trait TPayload
 * @package Rise
 * @property Request $request
 */
trait TPayload {

    /**
     * @var RequestPayload
     */
    private $payload;

    /**
     * @return RequestPayload
     */
    public function getPayload() {
        return $this->payload;
    }

    /**
     * @param RequestPayload $payload
     * @return $this
     */
    protected function setPayload(RequestPayload $payload) {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @throws ValidationException
     */
    public function onConstruct() {
        $rawBody = $this->request->getRawBody();

        /** @var RequestPayload $requestPayloadClass */
        $requestPayloadClass = $this->getRequestPayloadClass();

        $this->setPayload($requestPayloadClass::promote($rawBody));

        $errors = $this->getPayload()->validate();

        if ($errors) {
            throw new ValidationException($errors);
        }
    }


    /**
     * @param boolean $isAssociative
     * @return mixed
     */
    public function getRawPayload($isAssociative = true) {
        return $this
            ->request
            ->getJsonRawBody($isAssociative);
    }

    /**
     * @return string
     */
    protected abstract function getRequestPayloadClass();

}