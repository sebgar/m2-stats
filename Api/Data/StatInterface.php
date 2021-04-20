<?php
namespace Sga\Stats\Api\Data;

interface StatInterface
{
    const STAT_ID = 'stat_id';
    const SESSION_ID = 'session_id';
    const CODE = 'code';
    const PARAMS = 'params';
    const COUNTER = 'counter';
    const CREATED_AT = 'created_at';

    /**
     * Get stat id
     *
     * @return int|null
     */
    public function getStatId();

    /**
     * Set stat id
     *
     * @param int $id
     * @return StatInterface
     */
    public function setStatId($id);

    /**
     * Get session_id
     *
     * @return string|null
     */
    public function getSessionId();

    /**
     * Set session_id
     *
     * @param string $value
     * @return StatInterface
     */
    public function setSessionId($value);

    /**
     * Get code
     *
     * @return string|null
     */
    public function getCode();

    /**
     * Set code
     *
     * @param string $value
     * @return StatInterface
     */
    public function setCode($value);

    /**
     * Get params
     *
     * @return array|null
     */
    public function getParams();

    /**
     * Set params
     *
     * @param array $value
     * @return StatInterface
     */
    public function setParams(array $value);

    /**
     * Get counter
     *
     * @return string|null
     */
    public function getCounter();

    /**
     * Set counter
     *
     * @param string $value
     * @return StatInterface
     */
    public function setCounter($value);

    /**
     * Get created_at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     *
     * @param string $value
     * @return StatInterface
     */
    public function setCreatedAt($value);

}
