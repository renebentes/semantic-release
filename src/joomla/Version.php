<?php

/**
 * Release Please Test
 *
 * @copyright  (C) 2026 Rene B. Pinto. <renebentes@yahoo.com.br>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Version information class.
 *
 * @since  2.3.0
 */
final class Version
{
    /**
     * Major release version.
     *
     * @var    integer
     * @since  2.3.0
     */
    public const MAJOR_VERSION = 0;

    /**
     * Minor release version.
     *
     * @var    integer
     * @since  2.3.0
     */
    public const MINOR_VERSION = 0;

    /**
     * Patch release version.
     *
     * @var    integer
     * @since  2.3.0
     */
    public const PATCH_VERSION = 0;

    /**
     * Extra release version info.
     *
     * This constant when not empty adds an additional identifier to the version string to reflect the development state.
     * For example, for 1.0.0 when this is set to 'dev' the version string will be `1.0.0-dev`.
     *
     * @var    string
     * @since  2.3.0
     */
    public const EXTRA_VERSION = 'dev';

    /**
     * Development status.
     *
     * @var    string
     * @since  2.3.0
     */
    public const DEV_STATUS = 'Development';

    /**
     * Release date.
     *
     * @var    string
     * @since  2.3.0
     */
    public const RELEASE_DATE = '17-February-2026';

    /**
     * Release time.
     *
     * @var    string
     * @since  2.3.0
     */
    public const RELEASE_TIME = '16:01';

    /**
     * Release timezone.
     *
     * @var    string
     * @since  2.3.0
     */
    public const RELEASE_TIMEZONE = 'UTC';
}
