<?php

    use \TYPO3\Surf\Domain\Model\Node;
    use \TYPO3\Surf\Domain\Model\SimpleWorkflow;

    $node = new Node('vagrant-dev');
    $node->setHostname('192.168.33.141');
    $node->setOption('username', 'www-data');

    $application = new \TYPO3\Surf\Application\TYPO3\Neos();
    $application->setContext('Production');
    $application->setDeploymentPath('/var/www/neos-vagrant-remote');
    $application->setOption('repositoryUrl', 'https://github.com/igodorogea/neos-vagrant-demo.git');

    $application->setOption('transferMethod', 'rsync');
    $application->setOption('packageMethod', 'git');
    // $application->setOption('updateMethod', NULL);
    
    $application->setOption('keepReleases', 5);
    $application->setOption('sitePackageKey', 'IvanG.NeosDemo');

    $workflow = new SimpleWorkflow();
    $workflow->setEnableRollback(TRUE);
    $deployment->setWorkflow($workflow);

    $application->addNode($node);
    $deployment->addApplication($application);