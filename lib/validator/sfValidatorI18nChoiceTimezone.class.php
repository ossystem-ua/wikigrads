<?php

/**
 * sfValidatorI18nChoiceTimezone validates than the value is a valid timezone.
 *
 */
class sfValidatorI18nChoiceTimezone extends sfValidatorChoice
{
    /**
     * Configures the current validator.
     *
     * Available options:
     *
     * @param array $options   An array of options
     * @param array $messages  An array of error messages
     *
     * @see sfValidatorChoice
     */
    protected function configure($options = array(), $messages = array())
    {
        parent::configure($options, $messages);

        // culture is deprecated
        $this->addOption('culture');

        $culture = isset($options['culture']) ? $options['culture'] : 'en';

        $timezone_groups = sfCultureInfo::getInstance($culture)->getTimeZones();
        $timezones = array();
        foreach ($timezone_groups as $tz_group)
        {
            $array_key = isset($tz_group[0]) ? $tz_group[0] : null;
            if (isset($tz_group[0]) and !empty($tz_group[0]))
            {
                $timezones[$array_key] = $tz_group[0];
            }
        }
        $timezones = array_unique($timezones);
        sort($timezones);

        $this->setOption('choices', $timezones);
    }
}