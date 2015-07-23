<?php namespace Rlima\Laravel5DoctrineODM;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

class LaravelDocumentManager implements ODM
{
    /**
     * @var null
     */
    private $dm = null;

    /**
     *
     * @param $config
     */
    public function __construct($config)
    {
        $server = $config['connection'][$config['default_connection']];
        $config = $config['configuration'][$config['default_connection']];

        $configuration = new Configuration();

        AnnotationDriver::registerAnnotationClasses();
        $anotationReader =  new AnnotationDriver(new AnnotationReader(), app_path('Documents'));

        $configuration->setProxyDir($config['proxy_dir']);
        $configuration->setProxyNamespace('Proxies');
        $configuration->setHydratorDir($config['hydrator_dir']);
        $configuration->setHydratorNamespace('Hydrators');
        $configuration->setMetadataDriverImpl($anotationReader);
        $configuration->setDefaultDB($server['dbname']);

        $this->dm = DocumentManager::create(new Connection(), $configuration);
    }

    /**
     * Get Document Manager Object
     * @return Doctrine\ODM\MongoDB\DocumentManager
     */
    public function getDocumentManager()
    {
        return $this->dm;
    }

    /**
     * @param $document
     * @return $this
     */
    public function persist($document)
    {
        $this->dm->persist($document);
        return $this;
    }

    /**
     * @param null $document
     * @param array $options
     * @return $this
     */
    public function flush($document = null, $options = array())
    {
        $this->dm->flush($document, $options);
        return $this;
    }
}