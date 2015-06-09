<?php

namespace Rise\Models\Request\Collection;

use \stdClass,

    \Rise\Models\Request;

/**
 * Class Base
 * @package Rise\Models\Request\Collection
 */
class Base extends Request {

    /**
     * @var integer
     */
    public $limit;

    /**
     * @var integer
     */
    public $page;

    /**
     * @var Order[]
     */
    public $order;

    /**
     * @return integer
     */
    public function getLimit() {
        return $this->limit;
    }

    /**
     * @param integer $limit
     * @return $this
     */
    public function setLimit($limit) {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return integer
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * @param integer $page
     * @return $this
     */
    public function setPage($page) {
        $this->page = $page;
        return $this;
    }

    /**
     * @return Order[]
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * @param Order[] $order
     * @return $this
     */
    public function setOrder(array $order = []) {
        $this->order = $order;
        return $this;
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function addOrder(Order $order) {
        $orders = $this->getOrder();
        $orders[] = $order;
        $this->setOrder($orders);
        return $this;
    }

    /**
     * @param integer $limit
     * @param integer $page
     * @param Order[] $order
     */
    public function __construct($limit = 20, $page = 1, array $order = []) {
        $this
            ->setLimit($limit)
            ->setPage($page)
            ->setOrder($order);
    }

    /**
     * @return array
     */
    public function relations() {
        return [
            'order' => [
                'type' => self::RELATION_MANY,
                'model' => '\Rise\Models\Request\Collection\Order'
            ]
        ];
    }

    /**
     * @param stdClass $payload
     * @return self
     */
    public static function cast(stdClass $payload) {
        /** @var Base $base */
        $base = parent::cast($payload);

        if (!$base->getOrder()) {
            $base->addOrder(new Order('name'));
        }

        return $base;
    }

    /**
     * @return integer
     */
    public function getOffset() {
        return $this->getLimit() * ($this->getPage() - 1);
    }

    /**
     * @return string
     */
    public function getOrderQuery() {
        $orderQuery = [];

        foreach ($this->getOrder() as $order) {
            $orderQuery[] = $order->getQuery();
        }

        return implode(',', $orderQuery);
    }

}