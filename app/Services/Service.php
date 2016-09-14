<?php

namespace App\Services;

/*
 * This file is part of the Sulaeman Example.
 *
 * (c) Sulaeman <me@sulaeman.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Contracts\Logging\Log;

class Service
{
    /**
     * The Log instance.
     *
     * @var \Illuminate\Contracts\Logging\Log|empty string
     */
    protected $log;

    /**
     * Create log.
     *
     * @param  string  $level
     * @param  string  $message
     * @param  array   $context   
     * @return void
     */
    protected function writeLog($level, $message, array $context = [])
    {
        if (is_null($this->log)) {
            $this->log = $this->getLogger();

            if (is_null($this->log)) {
                $this->log = '';
            }
        }

        if ( ! empty($this->log)) {
            $this->log->write($level, $message, $context);
        }
    }

    /**
     * Return Request instance.
     *
     * @return \Illuminate\Http\Request
     */
    public function getRequest()
    {
        return app('request');
    }

    /**
     * Return Log instance.
     *
     * @return \Illuminate\Contracts\Logging\Log
     */
    protected function getLogger()
    {
        return app('log');
    }
}
