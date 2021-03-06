<?php
declare(strict_types = 1);

/*
 * This file is part of the package t3g/intercept.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace App\Tests\Unit\Extractor;

use App\Extractor\GraylogLogEntry;
use PHPUnit\Framework\TestCase;

class GraylogLogEntryTest extends TestCase
{
    /**
     * @test
     */
    public function constructorExtractsValues()
    {
        $entry = new GraylogLogEntry([
            'application' => 'intercept',
            'ctxt_type' => 'triggerBamboo',
            'timestamp' => '2018-12-16T22:07:04.815Z',
            'env' => 'prod',
            'level' => 6,
            'message' => 'my message',
            'ctxt_branch' => 'master',
            'ctxt_change' => 12345,
            'ctxt_patch' => 2,
            'ctxt_bambooKey' => 'CORE-GTC-1234',
            'ctxt_vote' => '-1',
            'ctxt_triggeredBy' => 'interface',
            'ctxt_job_uuid' => 'f42e65f4-7696-4759-94b7-ebc511041657',
            'ctxt_status' => 'queued',
            'ctxt_sourceBranch' => '9.5',
            'ctxt_targetBranch' => 'master',
            'ctxt_tag' => 'v9.5.2',
        ]);
        $this->assertSame('triggerBamboo', $entry->type);
        $this->assertSame('prod', $entry->env);
        $this->assertSame(6, $entry->level);
        $this->assertSame('my message', $entry->message);
        $this->assertSame('master', $entry->branch);
        $this->assertSame(12345, $entry->change);
        $this->assertSame(2, $entry->patch);
        $this->assertSame('CORE-GTC-1234', $entry->bambooKey);
        $this->assertSame('-1', $entry->vote);
        $this->assertSame('interface', $entry->triggeredBy);
        $this->assertSame('22', $entry->time->format('H'));
        $this->assertSame('f42e65f4-7696-4759-94b7-ebc511041657', $entry->uuid);
        $this->assertSame('queued', $entry->status);
        $this->assertSame('9.5', $entry->sourceBranch);
        $this->assertSame('master', $entry->targetBranch);
        $this->assertSame('v9.5.2', $entry->tag);
    }

    public function constructorThrowsOnMissingDataDataProvider()
    {
        return [
            'nothing set' => [
                [],
            ],
            'application missing' => [[
                'ctxt_type' => 'triggerBamboo',
                'timestamp' => '2018-12-16T22:07:04.815Z',
                'env' => 'prod',
                'level' => 6,
                'message' => 'my message',
            ]],
            'triggeredBy wrong' => [[
                'ctxt_type' => 'triggerBamboo',
                'timestamp' => '2018-12-16T22:07:04.815Z',
                'ctxt_triggeredBy' => 'wrong trigger',
                'application' => 'intercept',
                'env' => 'prod',
                'level' => 6,
                'message' => 'my message',
            ]],
            'application wrong' => [[
                'application' => 'not intercept',
                'ctxt_type' => 'triggerBamboo',
                'timestamp' => '2018-12-16T22:07:04.815Z',
                'ctxt_triggeredBy' => 'api',
                'env' => 'prod',
                'level' => 6,
                'message' => 'my message',
            ]],
            'timestamp missing' => [[
                'application' => 'intercept',
                'ctxt_type' => 'triggerBamboo',
                'ctxt_triggeredBy' => 'api',
                'env' => 'prod',
                'level' => 6,
                'message' => 'my message',
            ]],
            'type missing' => [[
                'application' => 'intercept',
                'timestamp' => '2018-12-16T22:07:04.815Z',
                'ctxt_triggeredBy' => 'api',
                'env' => 'prod',
                'level' => 6,
                'message' => 'my message',
            ]],
            'env missing' => [[
                'application' => 'intercept',
                'ctxt_type' => 'triggerBamboo',
                'timestamp' => '2018-12-16T22:07:04.815Z',
                'ctxt_triggeredBy' => 'api',
                'level' => 6,
                'message' => 'my message',
            ]],
            'level missing' => [[
                'application' => 'intercept',
                'ctxt_type' => 'triggerBamboo',
                'timestamp' => '2018-12-16T22:07:04.815Z',
                'ctxt_triggeredBy' => 'api',
                'env' => 'prod',
                'message' => 'my message',
            ]],
            'message missing' => [[
                'application' => 'intercept',
                'ctxt_type' => 'triggerBamboo',
                'timestamp' => '2018-12-16T22:07:04.815Z',
                'ctxt_triggeredBy' => 'api',
                'env' => 'prod',
                'level' => 6,
            ]],
        ];
    }

    /**
     * @test
     * @dataProvider constructorThrowsOnMissingDataDataProvider
     */
    public function constructorThrowsOnMissingData(array $input)
    {
        $this->expectException(\RuntimeException::class);
        new GraylogLogEntry($input);
    }
}
