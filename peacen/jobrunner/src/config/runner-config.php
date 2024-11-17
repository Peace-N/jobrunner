<?php
/**
 * This is the Main configuration file we can configure retry attempts | delays | priorities
 */
return [
    /**
     * Maximum number of retry attempts when a job fails
     * @val | int
     */
    'attempts' => 2,
    /**
     * Delays between attemps in seconds
     */
    'delay' => 30,
];
