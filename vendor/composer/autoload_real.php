<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitce697b5f0ff3d81be8a7b007a655ac77
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitce697b5f0ff3d81be8a7b007a655ac77', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitce697b5f0ff3d81be8a7b007a655ac77', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitce697b5f0ff3d81be8a7b007a655ac77::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
