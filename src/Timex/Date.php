<?php
namespace Timex;
use DateTimeZone;

/**
 * Class Date
 * @package Timex
 */
class Date {
    /**
     * Dates
     * @var $dates array
     */
    private $dates = [];
    /**
     * @var $dateFormat string
     */
    private $dateFormat = 'Y-m-d H:i:s';

    private $isTimestamp = false;

    /**
     * @param $date
     * @return $this
     */
    public function add($date) {
        if($this->isTimestamp) {
            $dateInstance = new \DateTime();
            $this->dates[] = $dateInstance->setTimestamp($date);
        } else
            $this->dates[] =\DateTime::createFromFormat($this->dateFormat, $date);
        return $this;
    }

    /**
     * @param $format
     * @return $this
     */
    public function setFormat($format)
    {
        $this->dateFormat = $format;
        return $this;
    }

    /**
     * @param bool $isTimestamp
     * @return $this
     */
    public function isTimestamp($isTimestamp = true)
    {
        $this->isTimestamp = $isTimestamp;
        return $this;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        if(count($this->dates) > 0) {
            foreach ($this->dates as $date) {
                if($date !== false && $date instanceof \DateTime)
                    continue;
                else
                    return false;
            }
            return true;
        }
        return false;
    }

}