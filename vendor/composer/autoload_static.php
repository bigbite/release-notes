<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0d6c61fd0f46cf60f9125159b17958ae
{
    public static $files = array (
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
        'a4a119a56e50fbb293281d9a48007e0e' => __DIR__ . '/..' . '/symfony/polyfill-php80/bootstrap.php',
        '29d445a10083e232e454774a2e15db2f' => __DIR__ . '/../..' . '/inc/constants.php',
        '5e7a2cc0d82b2d6b34a44b9a4f082702' => __DIR__ . '/../..' . '/inc/asset-settings.php',
        'd1d9e0e109eef7257563d13e6e17e269' => __DIR__ . '/../..' . '/inc/utils.php',
        '8ec6a49adce1bc1fea1de3ce2bf3218f' => __DIR__ . '/../..' . '/inc/setup.php',
    );

    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'VariableAnalysis\\' => 17,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Php80\\' => 23,
        ),
        'P' => 
        array (
            'Psr\\EventDispatcher\\' => 20,
        ),
        'L' => 
        array (
            'League\\Config\\' => 14,
            'League\\CommonMark\\' => 18,
        ),
        'D' => 
        array (
            'Dflydev\\DotAccessData\\' => 22,
            'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 55,
        ),
        'B' => 
        array (
            'Big_Bite\\release-notes\\' => 23,
        ),
        'A' => 
        array (
            'Automattic\\Jetpack\\Autoloader\\' => 30,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'VariableAnalysis\\' => 
        array (
            0 => __DIR__ . '/..' . '/sirbrillig/phpcs-variable-analysis/VariableAnalysis',
        ),
        'Symfony\\Polyfill\\Php80\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php80',
        ),
        'Psr\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/event-dispatcher/src',
        ),
        'League\\Config\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/config/src',
        ),
        'League\\CommonMark\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/commonmark/src',
        ),
        'Dflydev\\DotAccessData\\' => 
        array (
            0 => __DIR__ . '/..' . '/dflydev/dot-access-data/src',
        ),
        'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 
        array (
            0 => __DIR__ . '/..' . '/dealerdirect/phpcodesniffer-composer-installer/src',
        ),
        'Big_Bite\\release-notes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
        'Automattic\\Jetpack\\Autoloader\\' => 
        array (
            0 => __DIR__ . '/..' . '/automattic/jetpack-autoloader/src',
        ),
    );

    public static $classMap = array (
        'Attribute' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Attribute.php',
        'Automattic\\Jetpack\\Autoloader\\AutoloadGenerator' => __DIR__ . '/..' . '/automattic/jetpack-autoloader/src/AutoloadGenerator.php',
        'Big_Bite\\Release_Notes\\AdminBar' => __DIR__ . '/../..' . '/inc/class-admin-bar.php',
        'Big_Bite\\Release_Notes\\Archive' => __DIR__ . '/../..' . '/inc/class-archive.php',
        'Big_Bite\\Release_Notes\\Loader' => __DIR__ . '/../..' . '/inc/class-loader.php',
        'Big_Bite\\Release_Notes\\PostType' => __DIR__ . '/../..' . '/inc/class-post-type.php',
        'Big_Bite\\Release_Notes\\RegisterSettings' => __DIR__ . '/../..' . '/inc/class-register-settings.php',
        'Big_Bite\\Release_Notes\\ReleaseNote' => __DIR__ . '/../..' . '/inc/class-release-note.php',
        'Big_Bite\\Release_Notes\\ReleasePublish' => __DIR__ . '/../..' . '/inc/class-release-publish.php',
        'Big_Bite\\Release_Notes\\RestEndpoints' => __DIR__ . '/../..' . '/inc/class-rest-endpoints.php',
        'Big_Bite\\Release_Notes\\Widget' => __DIR__ . '/../..' . '/inc/class-widget.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Nette\\ArgumentOutOfRangeException' => __DIR__ . '/..' . '/nette/utils/src/exceptions.php',
        'Nette\\DeprecatedException' => __DIR__ . '/..' . '/nette/utils/src/exceptions.php',
        'Nette\\DirectoryNotFoundException' => __DIR__ . '/..' . '/nette/utils/src/exceptions.php',
        'Nette\\FileNotFoundException' => __DIR__ . '/..' . '/nette/utils/src/exceptions.php',
        'Nette\\HtmlStringable' => __DIR__ . '/..' . '/nette/utils/src/HtmlStringable.php',
        'Nette\\IOException' => __DIR__ . '/..' . '/nette/utils/src/exceptions.php',
        'Nette\\InvalidArgumentException' => __DIR__ . '/..' . '/nette/utils/src/exceptions.php',
        'Nette\\InvalidStateException' => __DIR__ . '/..' . '/nette/utils/src/exceptions.php',
        'Nette\\Iterators\\CachingIterator' => __DIR__ . '/..' . '/nette/utils/src/Iterators/CachingIterator.php',
        'Nette\\Iterators\\Mapper' => __DIR__ . '/..' . '/nette/utils/src/Iterators/Mapper.php',
        'Nette\\Localization\\ITranslator' => __DIR__ . '/..' . '/nette/utils/src/compatibility.php',
        'Nette\\Localization\\Translator' => __DIR__ . '/..' . '/nette/utils/src/Translator.php',
        'Nette\\MemberAccessException' => __DIR__ . '/..' . '/nette/utils/src/exceptions.php',
        'Nette\\NotImplementedException' => __DIR__ . '/..' . '/nette/utils/src/exceptions.php',
        'Nette\\NotSupportedException' => __DIR__ . '/..' . '/nette/utils/src/exceptions.php',
        'Nette\\OutOfRangeException' => __DIR__ . '/..' . '/nette/utils/src/exceptions.php',
        'Nette\\Schema\\Context' => __DIR__ . '/..' . '/nette/schema/src/Schema/Context.php',
        'Nette\\Schema\\DynamicParameter' => __DIR__ . '/..' . '/nette/schema/src/Schema/DynamicParameter.php',
        'Nette\\Schema\\Elements\\AnyOf' => __DIR__ . '/..' . '/nette/schema/src/Schema/Elements/AnyOf.php',
        'Nette\\Schema\\Elements\\Base' => __DIR__ . '/..' . '/nette/schema/src/Schema/Elements/Base.php',
        'Nette\\Schema\\Elements\\Structure' => __DIR__ . '/..' . '/nette/schema/src/Schema/Elements/Structure.php',
        'Nette\\Schema\\Elements\\Type' => __DIR__ . '/..' . '/nette/schema/src/Schema/Elements/Type.php',
        'Nette\\Schema\\Expect' => __DIR__ . '/..' . '/nette/schema/src/Schema/Expect.php',
        'Nette\\Schema\\Helpers' => __DIR__ . '/..' . '/nette/schema/src/Schema/Helpers.php',
        'Nette\\Schema\\Message' => __DIR__ . '/..' . '/nette/schema/src/Schema/Message.php',
        'Nette\\Schema\\Processor' => __DIR__ . '/..' . '/nette/schema/src/Schema/Processor.php',
        'Nette\\Schema\\Schema' => __DIR__ . '/..' . '/nette/schema/src/Schema/Schema.php',
        'Nette\\Schema\\ValidationException' => __DIR__ . '/..' . '/nette/schema/src/Schema/ValidationException.php',
        'Nette\\SmartObject' => __DIR__ . '/..' . '/nette/utils/src/SmartObject.php',
        'Nette\\StaticClass' => __DIR__ . '/..' . '/nette/utils/src/StaticClass.php',
        'Nette\\UnexpectedValueException' => __DIR__ . '/..' . '/nette/utils/src/exceptions.php',
        'Nette\\Utils\\ArrayHash' => __DIR__ . '/..' . '/nette/utils/src/Utils/ArrayHash.php',
        'Nette\\Utils\\ArrayList' => __DIR__ . '/..' . '/nette/utils/src/Utils/ArrayList.php',
        'Nette\\Utils\\Arrays' => __DIR__ . '/..' . '/nette/utils/src/Utils/Arrays.php',
        'Nette\\Utils\\AssertionException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\Utils\\Callback' => __DIR__ . '/..' . '/nette/utils/src/Utils/Callback.php',
        'Nette\\Utils\\DateTime' => __DIR__ . '/..' . '/nette/utils/src/Utils/DateTime.php',
        'Nette\\Utils\\FileInfo' => __DIR__ . '/..' . '/nette/utils/src/Utils/FileInfo.php',
        'Nette\\Utils\\FileSystem' => __DIR__ . '/..' . '/nette/utils/src/Utils/FileSystem.php',
        'Nette\\Utils\\Finder' => __DIR__ . '/..' . '/nette/utils/src/Utils/Finder.php',
        'Nette\\Utils\\Floats' => __DIR__ . '/..' . '/nette/utils/src/Utils/Floats.php',
        'Nette\\Utils\\Helpers' => __DIR__ . '/..' . '/nette/utils/src/Utils/Helpers.php',
        'Nette\\Utils\\Html' => __DIR__ . '/..' . '/nette/utils/src/Utils/Html.php',
        'Nette\\Utils\\IHtmlString' => __DIR__ . '/..' . '/nette/utils/src/compatibility.php',
        'Nette\\Utils\\Image' => __DIR__ . '/..' . '/nette/utils/src/Utils/Image.php',
        'Nette\\Utils\\ImageException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\Utils\\Json' => __DIR__ . '/..' . '/nette/utils/src/Utils/Json.php',
        'Nette\\Utils\\JsonException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\Utils\\ObjectHelpers' => __DIR__ . '/..' . '/nette/utils/src/Utils/ObjectHelpers.php',
        'Nette\\Utils\\Paginator' => __DIR__ . '/..' . '/nette/utils/src/Utils/Paginator.php',
        'Nette\\Utils\\Random' => __DIR__ . '/..' . '/nette/utils/src/Utils/Random.php',
        'Nette\\Utils\\Reflection' => __DIR__ . '/..' . '/nette/utils/src/Utils/Reflection.php',
        'Nette\\Utils\\RegexpException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\Utils\\Strings' => __DIR__ . '/..' . '/nette/utils/src/Utils/Strings.php',
        'Nette\\Utils\\Type' => __DIR__ . '/..' . '/nette/utils/src/Utils/Type.php',
        'Nette\\Utils\\UnknownImageFileException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\Utils\\Validators' => __DIR__ . '/..' . '/nette/utils/src/Utils/Validators.php',
        'PhpToken' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/PhpToken.php',
        'Stringable' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Stringable.php',
        'UnhandledMatchError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/UnhandledMatchError.php',
        'ValueError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/ValueError.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0d6c61fd0f46cf60f9125159b17958ae::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0d6c61fd0f46cf60f9125159b17958ae::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0d6c61fd0f46cf60f9125159b17958ae::$classMap;

        }, null, ClassLoader::class);
    }
}
