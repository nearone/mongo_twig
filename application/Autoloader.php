<?php

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Autoloads Twig classes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Autoloader
{
    /**
     * Registers Twig_Autoloader as an SPL autoloader.
     *
     * @param bool $prepend Whether to prepend the autoloader or not.
     */
    public static function register($prepend = false)
    {
        if (PHP_VERSION_ID < 50300) {
            spl_autoload_register(array(__CLASS__, 'autoload'));
        } else {
            spl_autoload_register(array(__CLASS__, 'autoload'), true, $prepend);
        }
    }

    /**
     * Handles autoloading of classes.
     *
     * @param string $class A class name.
     */
    public static function autoload($class)
    {
        if(file_exists(APPLICATION_PATH . "/Controllers/{$class}.php")){
            include APPLICATION_PATH . "/Controllers/{$class}.php";
        }elseif(file_exists(APPLICATION_PATH . "/Core/{$class}.php")){
            include APPLICATION_PATH . "/Core/{$class}.php";
        }elseif(file_exists(APPLICATION_PATH . "/{$class}.php")){
            include APPLICATION_PATH . "/{$class}.php";
        }
    }
}
