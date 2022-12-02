<?php

/**
 * sfWidgetFormI18nSelectTimezone represents a timezone HTML select tag.
 *
 */
class sfWidgetFormI18nSelectTimezone extends sfWidgetFormSelect
{

    static $display_keys = array(
        'identifier'        => 0,
        'timezone'          => 1,
        'timezone_abbr'     => 2,
        'timezone_dst'      => 3,
        'timezone_dst_abbr' => 4,
        'city'              => 5,
    );

    /**
     * Constructor.
     *
     * Available options:
     *
     *  * culture:    The culture to use for internationalized strings (required)
     *  * add_empty:  Whether to add a first empty value or not (false by default)
     *                If the option is not a Boolean, the value will be used as the text value
     *  * display:    Timezone display format, can be one of: identifier, timezone, timezone_abbr, timezone_dst, timezone_dst_abbr, city
     *                Default is identifier
     *
     * @param array $options     An array of options
     * @param array $attributes  An array of default HTML attributes
     *
     * @see sfWidgetFormSelect
     */
    protected function configure($options = array(), $attributes = array())
    {
        parent::configure($options, $attributes);


        $this->addRequiredOption('culture');
        $this->addOption('add_empty', false);
        $this->addOption('display', 'identifier');

        $culture = isset($options['culture']) ? $options['culture'] : 'en';

        $display = isset($options['display']) ? $options['display'] : 'identifier';
        $display_key = isset(self::$display_keys[$display]) ? self::$display_keys[$display] : 0;

        $timezone_groups = sfCultureInfo::getInstance($culture)->getTimeZones();

        $timezones = array();
        foreach ($timezone_groups as $tz_group)
        {
            $array_key = isset($tz_group[0]) ? $tz_group[0] : null;
            if (isset($tz_group[$display_key]) and !empty($tz_group[$display_key]))
            {
                $timezones[$array_key] = $tz_group[$display_key];
            }
        }

        // Remove duplicate values
        $timezones = array_unique($timezones);

        asort($timezones);

        $addEmpty = isset($options['add_empty']) ? $options['add_empty'] : false;
        if (false !== $addEmpty)
        {
            $timezones = array_merge(array('' => true === $addEmpty ? '' : $addEmpty), $timezones);
        }

        $this->setOption('choices', $timezones);
    }
}