<?php

namespace ContainerG0uxzCP;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolderf4dde = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializerc3028 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties4894b = [
        
    ];

    public function getConnection()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getConnection', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getMetadataFactory', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getExpressionBuilder', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'beginTransaction', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->beginTransaction();
    }

    public function getCache()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getCache', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getCache();
    }

    public function transactional($func)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'transactional', array('func' => $func), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->transactional($func);
    }

    public function commit()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'commit', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->commit();
    }

    public function rollback()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'rollback', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getClassMetadata', array('className' => $className), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'createQuery', array('dql' => $dql), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'createNamedQuery', array('name' => $name), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'createQueryBuilder', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'flush', array('entity' => $entity), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'clear', array('entityName' => $entityName), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->clear($entityName);
    }

    public function close()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'close', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->close();
    }

    public function persist($entity)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'persist', array('entity' => $entity), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'remove', array('entity' => $entity), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'refresh', array('entity' => $entity), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'detach', array('entity' => $entity), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'merge', array('entity' => $entity), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getRepository', array('entityName' => $entityName), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'contains', array('entity' => $entity), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getEventManager', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getConfiguration', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'isOpen', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getUnitOfWork', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getProxyFactory', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'initializeObject', array('obj' => $obj), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'getFilters', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'isFiltersStateClean', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'hasFilters', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return $this->valueHolderf4dde->hasFilters();
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

        $instance->initializerc3028 = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolderf4dde) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolderf4dde = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolderf4dde->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, '__get', ['name' => $name], $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        if (isset(self::$publicProperties4894b[$name])) {
            return $this->valueHolderf4dde->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf4dde;

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

        $targetObject = $this->valueHolderf4dde;
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
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf4dde;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolderf4dde;
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
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, '__isset', array('name' => $name), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf4dde;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolderf4dde;
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
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, '__unset', array('name' => $name), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderf4dde;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolderf4dde;
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
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, '__clone', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        $this->valueHolderf4dde = clone $this->valueHolderf4dde;
    }

    public function __sleep()
    {
        $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, '__sleep', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;

        return array('valueHolderf4dde');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerc3028 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerc3028;
    }

    public function initializeProxy() : bool
    {
        return $this->initializerc3028 && ($this->initializerc3028->__invoke($valueHolderf4dde, $this, 'initializeProxy', array(), $this->initializerc3028) || 1) && $this->valueHolderf4dde = $valueHolderf4dde;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolderf4dde;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolderf4dde;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
