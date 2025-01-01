<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint\Contracts;

interface ConsoleCommand
{
    /**
     * Write a string as information output.
     *
     * @param string          $string
     * @param int|string|null $verbosity
     *
     * @return void
     */
    public function info($string, $verbosity = null);

    /**
     * Write a string as standard output.
     *
     * @param string          $string
     * @param string|null     $style
     * @param int|string|null $verbosity
     *
     * @return void
     */
    public function line($string, $style = null, $verbosity = null);

    /**
     * Write a string as comment output.
     *
     * @param string          $string
     * @param int|string|null $verbosity
     *
     * @return void
     */
    public function comment($string, $verbosity = null);

    /**
     * Write a string as error output.
     *
     * @param string          $string
     * @param int|string|null $verbosity
     *
     * @return void
     */
    public function error($string, $verbosity = null);

    /**
     * Write a string as warning output.
     *
     * @param string          $string
     * @param int|string|null $verbosity
     *
     * @return void
     */
    public function warn($string, $verbosity = null);

    /**
     * Write a string in an alert box.
     *
     * @param string          $string
     * @param int|string|null $verbosity
     *
     * @return void
     */
    public function alert($string, $verbosity = null);
}
