<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitbea6b2bf0b11f6296d83fd8e0cf85a3e
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

        spl_autoload_register(array('ComposerAutoloaderInitbea6b2bf0b11f6296d83fd8e0cf85a3e', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitbea6b2bf0b11f6296d83fd8e0cf85a3e', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitbea6b2bf0b11f6296d83fd8e0cf85a3e::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}