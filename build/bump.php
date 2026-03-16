<?php

/**
 * Script used to make a version bump
 * Updates all versions xmls and php files
 *
 * Usage: php build/bump.php -v <version>
 *
 * Examples:
 * - php build/bump.php -v 1.0.0-dev
 * - php build/bump.php -v 1.0.0-beta1
 * - php build/bump.php -v 1.0.0-beta1-dev
 * - php build/bump.php -v 1.0.0-beta2
 * - php build/bump.php -v 1.0.0-rc1
 * - php build/bump.php -v 1.0.0
 * - php build/bump.php -v 1.0.0 -d "2026-03-09 13:00"
 * - /usr/bin/php /path/to/build/bump.php -v 1.0.0
 *
 * From https://github.com/joomla/joomla-cms/blob/6.0-dev/build/bump.php
 *
 * @package    GovBR.Build
 * @copyright  (C) 2026 Rene B. Pinto <renebentes@yahoo.com.br>
 *             (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Functions.
function usage($command)
{
    echo PHP_EOL;
    echo 'Usage: php ' . $command . ' [options]' . PHP_EOL;
    echo PHP_TAB . '[options]:' . PHP_EOL;
    echo PHP_TAB . PHP_TAB . '-v <version>:' . PHP_TAB . PHP_TAB . 'Version (ex: 1.0.0-dev, 1.0.0-beta1, 1.0.0-beta1-dev, 1.0.0-rc1, 1.0.0)' . PHP_EOL;
    echo PHP_TAB . PHP_TAB . '-d <release date>:' . PHP_TAB . 'Release Date in ISO 8601 format [optional] (ex: "2026-03-09 13:00")' . PHP_EOL;
    echo PHP_EOL;
}

// Constants.
const PHP_TAB = "\t";

// File paths.
$coreXmlFiles = [
    '/govbr/templateDetails.xml',
];

$jsonFiles = [
    '/composer.json',
    '/package.json',
    '/package-lock.json',
];

$readMeFiles = [
    '/src/joomla/README.md',
];

/*
 * Change copyright date exclusions.
 * Some systems may try to scan the .git directory, exclude it.
 * Also exclude build resources such as the packaging space or the API documentation build
 * as well as external libraries.
 */
$directoryLoopExcludeDirectories = [
    '/.git',
    '/vendor/',
    '/node_modules/',
];

$directoryLoopExcludeFiles = [];

// Check arguments (exit if incorrect cli arguments).
$opts = getopt("v:d:");

if (empty($opts['v'])) {
    usage($argv[0]);
    die();
}

// Check version string (exit if not correct).
$versionParts = explode('-', $opts['v']);

if (!preg_match('#^[0-9]+\.[0-9]+\.[0-9]+$#', $versionParts[0])) {
    usage($argv[0]);
    die();
}

if (isset($versionParts[1]) && !preg_match('#(dev|alpha|beta|rc)[0-9]*#', $versionParts[1])) {
    usage($argv[0]);
    die();
}

if (isset($versionParts[2]) && $versionParts[2] !== 'dev') {
    usage($argv[0]);
    die();
}

// Make sure we use the correct language and timezone.
setlocale(LC_ALL, 'en_GB');
date_default_timezone_set('UTC');

// Make sure file and folder permissions are set correctly.
umask(022);

// Get version dev status.
$dev_status = 'Stable';

if (!isset($versionParts[1])) {
    $versionParts[1] = '';
} else {
    if (preg_match('#^dev#', $versionParts[1])) {
        $dev_status = 'Development';
    } elseif (preg_match('#^alpha#', $versionParts[1])) {
        $dev_status = 'Alpha';
    } elseif (preg_match('#^beta#', $versionParts[1])) {
        $dev_status = 'Beta';
    } elseif (preg_match('#^rc#', $versionParts[1])) {
        $dev_status = 'Release Candidate';
    }
}

if (!isset($versionParts[2])) {
    $versionParts[2] = '';
} else {
    $dev_status = 'Development';
}

// Set version properties.
$versionSubParts = explode('.', $versionParts[0]);

// The release date
$date = new DateTime($opts['d'] ?? 'now');

// The version data
$version = [
    'main'             => $versionSubParts[0] . '.' . $versionSubParts[1],
    'major'            => $versionSubParts[0],
    'minor'            => $versionSubParts[1],
    'patch'            => $versionSubParts[2],
    'extra'            => (!empty($versionParts[1]) ? $versionParts[1] : '') . (!empty($versionParts[2]) ? (!empty($versionParts[1]) ? '-' : '') . $versionParts[2] : ''),
    'release'          => $versionSubParts[0] . '.' . $versionSubParts[1] . '.' . $versionSubParts[2],
    'dev_level'        => $versionSubParts[2] . (!empty($versionParts[1]) ? '-' . $versionParts[1] : '') . (!empty($versionParts[2]) ? '-' . $versionParts[2] : ''),
    'dev_status'       => $dev_status,
    'build'            => '',
    'release_date'     => $date->format('j-F-Y'),
    'release_time'     => $date->format('H:i'),
    'release_timezone' => 'UTC',
    'creation_date'    => $date->format('Y-m'),
];

// Prints version information.
echo PHP_EOL;
echo 'Version data:' . PHP_EOL;
echo '- Main:' . PHP_TAB . PHP_TAB . PHP_TAB . $version['main'] . PHP_EOL;
echo '- Release:' . PHP_TAB . PHP_TAB . $version['release'] . PHP_EOL;
echo '- Full:' . PHP_TAB . PHP_TAB . PHP_TAB . $version['main'] . '.' . $version['dev_level'] . PHP_EOL;
echo '- Build:' . PHP_TAB . PHP_TAB . $version['build'] . PHP_EOL;
echo '- Dev Level:' . PHP_TAB . PHP_TAB . $version['dev_level'] . PHP_EOL;
echo '- Dev Status:' . PHP_TAB . PHP_TAB . $version['dev_status'] . PHP_EOL;
echo '- Release date:' . PHP_TAB . PHP_TAB . $version['release_date'] . PHP_EOL;
echo '- Release time:' . PHP_TAB . PHP_TAB . $version['release_time'] . PHP_EOL;
echo '- Release timezone:' . PHP_TAB . $version['release_timezone'] . PHP_EOL;
echo '- Creation date:' . PHP_TAB . $version['creation_date'] . PHP_EOL;
echo PHP_EOL;

$rootPath = \dirname(__DIR__);

// Updates the version and creation date in core xml files.
foreach ($coreXmlFiles as $coreXmlFile) {
    if (file_exists($rootPath . $coreXmlFile)) {
        $fileContents = file_get_contents($rootPath . $coreXmlFile);
        $fileContents = preg_replace('#<version>[^<]*</version>#', '<version>' . $version['main'] . '.' . $version['dev_level'] . '</version>', $fileContents);
        $fileContents = preg_replace('#<creationDate>[^<]*</creationDate>#', '<creationDate>' . $version['creation_date'] . '</creationDate>', $fileContents);
        file_put_contents($rootPath . $coreXmlFile, $fileContents);
    }
}

// Updates the version in the package.json and composer.json files.
foreach ($jsonFiles as $jsonFile) {
    if (file_exists($rootPath . $jsonFile)) {
        $package          = json_decode(file_get_contents($rootPath . $jsonFile));
        $package->version = $version['release'];

        // @todo use a native formatter whenever https://github.com/php/php-src/issues/8864 is resolved
        file_put_contents($rootPath . $jsonFile, str_replace('    ', '  ', json_encode($package, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) . "\n");
    }
}

// Updates the version in readme files.
foreach ($readMeFiles as $readMeFile) {
    if (file_exists($rootPath . $readMeFile)) {
        $fileContents = file_get_contents($rootPath . $readMeFile);
        $fileContents = preg_replace('#Test v[0-9]+\.[0-9]#', 'Test v' . $version['main'], $fileContents);
        file_put_contents($rootPath . $readMeFile, $fileContents);
    }
}

$changedFilesSinceVersion  = 0;
$year                      = date('Y');
$directory                 = new RecursiveDirectoryIterator($rootPath);
$iterator                  = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);

foreach ($iterator as $file) {
    if ($file->isFile()) {
        $filePath     = $file->getPathname();
        $relativePath = str_replace($rootPath, '', $filePath);

        // Exclude certain extensions.
        if (preg_match('#\.(png|jpeg|jpg|gif|bmp|ico|webp|svg|woff|woff2|ttf|eot)$#', $filePath)) {
            continue;
        }

        // Exclude certain files.
        if (\in_array($relativePath, $directoryLoopExcludeFiles)) {
            continue;
        }

        // Exclude certain directories.
        $continue = true;

        foreach ($directoryLoopExcludeDirectories as $excludeDirectory) {
            if (preg_match('#^' . preg_quote($excludeDirectory) . '#', $relativePath)) {
                $continue = false;
                break;
            }
        }

        if ($continue) {
            $changeSinceVersion  = false;

            // Load the file.
            $fileContents = file_get_contents($filePath);

            // Check if need to change the since version.
            if ($relativePath !== '/build/bump.php' && preg_match('#__DEPLOY_VERSION__#', $fileContents)) {
                $changeSinceVersion = true;
                $fileContents       = preg_replace('#__DEPLOY_VERSION__#', $version['release'], $fileContents);
                $changedFilesSinceVersion++;
            }

            // Save the file.
            if ($changeSinceVersion) {
                file_put_contents($filePath, $fileContents);
            }
        }
    }
}

if ($changedFilesSinceVersion > 0) {
    echo '- Since Version changed in ' . $changedFilesSinceVersion . ' files.' . PHP_EOL;
    echo PHP_EOL;
}

echo 'Version bump complete!' . PHP_EOL;
