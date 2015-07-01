<?php

namespace App\Controllers\User;

use \Phalcon\Http\Response,

    \Rise\Controller\Simple,

    \App\Models\User;

/**
 * Class Create
 * @package App\Controllers\User
 */
class Create extends Simple {

    /**
     * @return Response
     */
    public function run() {
        /** @var User $user */
        $user = (new User())->assign($this->getRawPayload());
        $user->save();

        return $this->response($user->toArray());
    }

}