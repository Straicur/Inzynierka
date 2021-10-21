<?php

namespace ContainerL0scyJe;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolder344a9 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializerafdc0 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties7bd9a = [
        
    ];

    public function getConnection()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getConnection', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getMetadataFactory', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getExpressionBuilder', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'beginTransaction', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->beginTransaction();
    }

    public function getCache()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getCache', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getCache();
    }

    public function transactional($func)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'transactional', array('func' => $func), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->transactional($func);
    }

    public function commit()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'commit', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->commit();
    }

    public function rollback()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'rollback', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getClassMetadata', array('className' => $className), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'createQuery', array('dql' => $dql), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'createNamedQuery', array('name' => $name), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'createQueryBuilder', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'flush', array('entity' => $entity), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'clear', array('entityName' => $entityName), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->clear($entityName);
    }

    public function close()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'close', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->close();
    }

    public function persist($entity)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'persist', array('entity' => $entity), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'remove', array('entity' => $entity), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'refresh', array('entity' => $entity), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'detach', array('entity' => $entity), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'merge', array('entity' => $entity), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getRepository', array('entityName' => $entityName), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'contains', array('entity' => $entity), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getEventManager', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getConfiguration', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'isOpen', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getUnitOfWork', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getProxyFactory', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'initializeObject', array('obj' => $obj), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'getFilters', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'isFiltersStateClean', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'hasFilters', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return $this->valueHolder344a9->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializerafdc0 = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolder344a9) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder344a9 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder344a9->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, '__get', ['name' => $name], $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        if (isset(self::$publicProperties7bd9a[$name])) {
            return $this->valueHolder344a9->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder344a9;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder344a9;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder344a9;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder344a9;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, '__isset', array('name' => $name), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder344a9;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder344a9;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, '__unset', array('name' => $name), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder344a9;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder344a9;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, '__clone', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        $this->valueHolder344a9 = clone $this->valueHolder344a9;
    }

    public function __sleep()
    {
        $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, '__sleep', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;

        return array('valueHolder344a9');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerafdc0 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerafdc0;
    }

    public function initializeProxy() : bool
    {
        return $this->initializerafdc0 && ($this->initializerafdc0->__invoke($valueHolder344a9, $this, 'initializeProxy', array(), $this->initializerafdc0) || 1) && $this->valueHolder344a9 = $valueHolder344a9;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder344a9;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder344a9;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
