<?php
declare(strict_types = 1);

namespace T3G\Intercept\Slack;


/**
 * Class SlackMessageParser
 *
 * Parses the slack message format send to us via Bamboo Slack Notification hook
 *
 * @package T3G\Intercept
 */
class MessageParser
{
    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    public function parseMessage() : string
    {
        if (
            !empty($_POST['payload']) &&
            preg_match('/<https:\/\/bamboo\.typo3\.com\/browse\/(?<buildKey>.*?)\|/', $_POST['payload'], $matches)
        ) {
            return $matches['buildKey'];
        }
        throw new \InvalidArgumentException('SlackMessage could not be parsed.');
    }
}