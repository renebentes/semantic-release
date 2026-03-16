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
 * @since  __DEPLOY_VERSION__
 */
final class Version
{
    /**
     * Major release version.
     *
     * @var    integer
     * @since  __DEPLOY_VERSION__
     */
    public const MAJOR_VERSION = 0;

    /**
     * Minor release version.
     *
     * @var    integer
     * @since  __DEPLOY_VERSION__
     */
    public const MINOR_VERSION = 0;

    /**
     * Patch release version.
     *
     * @var    integer
     * @since  __DEPLOY_VERSION__
     */
    public const PATCH_VERSION = 0;

    /**
     * Extra release version info.
     *
     * This constant when not empty adds an additional identifier to the version string to reflect the development state.
     * For example, for 1.0.0 when this is set to 'dev' the version string will be `1.0.0-dev`.
     *
     * @var    string
     * @since  __DEPLOY_VERSION__
     */
    public const EXTRA_VERSION = 'dev';

    /**
     * Development status.
     *
     * @var    string
     * @since  __DEPLOY_VERSION__
     */
    public const DEV_STATUS = 'Development';

    /**
     * Release date.
     *
     * @var    string
     * @since  __DEPLOY_VERSION__
     */
    public const RELEASE_DATE = '17-February-2026';

    /**
     * Release time.
     *
     * @var    string
     * @since  __DEPLOY_VERSION__
     */
    public const RELEASE_TIME = '16:01';

    /**
     * Release timezone.
     *
     * @var    string
     * @since  __DEPLOY_VERSION__
     */
    public const RELEASE_TIMEZONE = 'UTC';
}
