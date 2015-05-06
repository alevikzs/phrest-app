<?php

namespace App\Components\Controller;

use \Phalcon\Http\Response,
    \Phalcon\Mvc\Model\Criteria;

/**
 * Class Collection
 * @package App\Components\Controller
 */
abstract class Collection extends Base {

    const DEFAULT_LIMIT = 20;

    const DEFAULT_PAGE = 1;

    /**
     * @return integer
     */
    public function getOffset() {
        return $this->getLimit() * ($this->getPage() - 1);
    }

    /**
     * @return integer
     */
    protected function getLimit() {
        $limit = (int) $this->request->get('limit');
        if ($limit) {
            return $limit;
        }
        return self::DEFAULT_LIMIT;
    }

    /**
     * @return integer
     */
    protected function getPage() {
        $page = (int) $this->request->get('page');
        if ($page) {
            return $page;
        }
        return self::DEFAULT_PAGE;
    }

    /**
     * @param integer $count
     * @return boolean
     */
    private function hasNext($count) {
        return $count - $this->getPage() * $this->getLimit() > 0;
    }

    /**
     * @param Criteria $query
     * @return Response
     */
    public function response(Criteria $query) {
        $countQuery = clone $query;
        $count = $countQuery
            ->execute()
            ->count();
        $has_next = $this->hasNext($count);
        return $this->responseEmpty()
            ->setJsonContent([
                'list' => $query
                    ->limit($this->getLimit(), $this->getOffset())
                    ->execute()
                    ->toArray(),
                'count' => $count,
                'has_next' => $has_next
            ]);
    }

}