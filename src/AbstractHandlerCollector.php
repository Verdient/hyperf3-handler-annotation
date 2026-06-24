<?php

declare(strict_types=1);

namespace Verdient\Hyperf3\HandlerAnnotation;

use Hyperf\Collection\Arr;
use Hyperf\Di\MetadataCollectorInterface;
use Override;

use function Hyperf\Support\make;

/**
 * 处理器收集器
 *
 * @template TObject of object
 *
 * @author Verdient。
 */
class AbstractHandlerCollector implements MetadataCollectorInterface
{
    /**
     * 子类必须覆盖这个属性
     *
     * @author Verdient。
     */
    protected static array $container = [];

    /**
     * 收集类
     *
     * @param string $className 类的名称
     * @param AbstractHandlerAnnotation $annotation 注解
     *
     * @author Verdient。
     */
    public static function collectClass(string $className, AbstractHandlerAnnotation $annotation): void
    {
        $identifier = $annotation->identifier();

        static::set($identifier, $className);
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public static function clear(?string $key = null): void
    {
        if ($key === null) {
            static::$container = [];
        } else {
            unset(static::$container[$key]);
        }
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public static function get(string $key, $default = null)
    {
        return Arr::get(static::$container, $key, $default);
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public static function set(string $key, $value): void
    {
        Arr::set(static::$container, $key, $value);
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public static function serialize(): string
    {
        return serialize(static::$container);
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public static function deserialize(string $metadata): bool
    {
        static::$container = unserialize($metadata);

        return true;
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public static function list(): array
    {
        return static::$container;
    }

    /**
     * 检测处理器是否存在
     *
     * @param AbstractHandlerAnnotation $annotation 注解
     *
     * @author Verdient。
     */
    public static function has(AbstractHandlerAnnotation $annotation): bool
    {
        return Arr::has(static::$container, $annotation->identifier());
    }

    /**
     * 获取处理器
     *
     * @param AbstractHandlerAnnotation $annotation 注解
     *
     * @return ?TObject
     * @author Verdient。
     */
    public static function resolve(AbstractHandlerAnnotation $annotation): ?object
    {
        $class = static::get($annotation->identifier());

        if ($class) {
            return make($class);
        }

        return null;
    }
}
