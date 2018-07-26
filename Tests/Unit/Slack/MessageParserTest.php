<?php
declare(strict_types = 1);

namespace T3G\Intercept\Tests\Unit\Slack;

use PHPUnit\Framework\TestCase;
use T3G\Intercept\Slack\MessageParser;

class MessageParserTest extends TestCase
{


    /**
     * @test
     * @return void
     */
    public function parseMessageReturnsCurrentBuildKey()
    {
        $_POST = [
            'payload' => '{
        "attachments":[{
            "color":"good","text":"<https://bamboo.typo3.com/browse/T3G-AP-25|T3G \u203a Apparel \u203a #25> passed. 6 passed. Manual run by <https://bamboo.typo3.com/browse/user/susanne.moog|Susanne Moog>","fallback":"T3G \u203a Apparel \u203a #25 passed. 6 passed. Manual run by Susanne Moog"}],"username":"Bamboo"}'
        ];

        $slackMessageParser = new MessageParser();
        $buildKey = $slackMessageParser->parseMessage();

        self::assertSame('T3G-AP-25', $buildKey);
    }

    /**
     * @test
     * @return void
     */
    public function parseMessageThrowsExceptionOnError()
    {
        $this->expectException(\InvalidArgumentException::class);

        $slackMessageParser = new MessageParser();
        $slackMessageParser->parseMessage();
    }
}
