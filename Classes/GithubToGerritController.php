<?php
declare(strict_types = 1);

namespace T3G\Intercept;

use T3G\Intercept\Forge\Client as ForgeClient;
use T3G\Intercept\Gerrit\CommitMessageCreator;
use T3G\Intercept\Git\Client;
use T3G\Intercept\Github\PatchSaver;
use T3G\Intercept\Github\PullRequest;

/**
 * Class GithubToGerritController
 *
 * @codeCoverageIgnore Integration tests only
 * @package T3G\Intercept
 */
class GithubToGerritController
{

    /**
     * @var string
     */
    private $repositoryPath;

    public function __construct(string $repositoryPath = '')
    {
        $this->repositoryPath = $repositoryPath;
    }

    public function transformPullRequestToGerritReview(string $payload)
    {
        $pullRequestInformation = new PullRequest($payload);

        $issueData = $pullRequestInformation->getIssueData();
        $userData = $pullRequestInformation->getUserData();

        $forgeClient = new ForgeClient();
        $result = $forgeClient->createIssue($issueData['title'], $issueData['body']);
        $issueNumber = (int)$result->id;

        $commitMessageCreator = new CommitMessageCreator();
        $commitMessage = $commitMessageCreator->create($issueData['title'], $issueData['body'], $issueNumber);

        $patchSaver = new PatchSaver();
        $localDiff = $patchSaver->getLocalDiff($pullRequestInformation->diffUrl);

        $gitClient = new Client($this->repositoryPath);
        $gitClient->commitPatchAsUser($localDiff, $userData, $commitMessage);
        $gitClient->pushToGerrit();

        $pullRequestInformation->closePullRequest();
    }



}